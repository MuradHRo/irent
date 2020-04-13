<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Comment;
use App\Report;
use App\Subcategory;
use App\Answer;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class advertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit','update','destroy','renew');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sub_categories = Subcategory::all();
        if (isset($request->subcategory_id))
        {
            $subcategory= Subcategory::findOrFail($request->subcategory_id);
            $advertisements=$subcategory->advertisements()->latest()->paginate(15);
            $category_id = $subcategory->category_id;
            $subcategory_id=$request->subcategory_id;
        }
        else
        {
            $advertisements=Advertisement::when($request->sub_category,function ($q) use ($request){
                return $q->where('subcategory_id',$request->sub_category);
            })->when($request->place,function ($q) use ($request){
                return $q->where('place','like','%'.$request->place.'%');
            })->when($request->name,function ($q)use ($request){
                return $q->where('name','like','%'.$request->name.'%');
            })->latest()->paginate(15);
            $category_id=0;
            $subcategory_id=0;
        }


        return view('advertisements.index',compact('advertisements','category_id','subcategory_id','subcategory','sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategories= Subcategory::all();
        return view('advertisements.create',compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'subcategory_id'=>'required',
            'texts.*'=>'required',
            'selections.*'=>'required',
            'name'=>'required',
            'short_description'=>'required|max:50',
            'price'=>'numeric|required',
            'price_per'=>'required',
            'place'=>'required'
        ]);
        $request_data=$request->except('texts','selections','image');
        $request_data['user_id']=auth()->user()->id;


        // Image
        if ($request->hasFile('image')) {
            $images=array();
            foreach ($request->image as $image)
            {
                Image::make($image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/advertisement_images/' . $image->hashName()));
                // hashName = make name unique to prevent duplication
                $images[] = $image->hashName();
            }
            $request_data['image']=implode(',',$images);
        }//end of if

        $advertisement=Advertisement::create($request_data);

        if (isset($request->texts)) {
            foreach ($request->texts as $question_id => $text) {
                Answer::create([
                    'text' => $text,
                    'advertisement_id' => $advertisement->id,
                    'question_id' => $question_id
                ]);
            }
        }
        if (isset($request->selections)) {
            foreach ($request->selections as $question_id => $selection) {
                Answer::create([
                    'selection_id' => $selection,
                    'advertisement_id' => $advertisement->id,
                    'question_id' => $question_id
                ]);
            }
        }
        // Update User Weight
        auth()->user()->update([
           'user_weight'=>auth()->user()->user_weight++
        ]);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('advertisements.index',['subcategory_id'=>$request->subcategory_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show($advertisement_id)
    {
        $advertisement = Advertisement::withTrashed()->find($advertisement_id);
        return view('advertisements.show' ,compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        $subcategories=Subcategory::all();
        $answers=$advertisement->answers;
        return view('advertisements.edit',compact('advertisement','subcategories','answers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        if (auth()->user()->owns($advertisement)) {
            $request->validate([
                'subcategory_id' => 'required',
                'texts.*' => 'required',
                'selections.*' => 'required',
                'name' => 'required',
                'short_description' => 'required|max:50',
                'price' => 'numeric|required',
                'price_per'=>'required',
                'place'=>'required'
            ]);
            $request_data = $request->except('texts', 'selections', 'image');

            // Image
            if ($request->hasFile('image')) {
                foreach (explode(',', $advertisement->image) as $image) {
                    if ($image != 'default.png') {
                        Storage::disk('public_uploads')->delete('/advertisement_images/' . $image);
                    }
                }

                $images = array();
                foreach ($request->image as $image) {
                    Image::make($image)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('uploads/advertisement_images/' . $image->hashName()));
                    // hashName = make name unique to prevent duplication
                    $images[] = $image->hashName();
                }
                $request_data['image'] = implode(',', $images);
            }//end of if


            $advertisement->update($request_data);

            if (isset($request->texts)) {
                foreach ($request->texts as $question_id => $text) {
                    $advertisement->answers()->where('question_id', $question_id)->update(['text' => $text]);
                }
            }

            if (isset($request->selections)) {
                foreach ($request->selections as $question_id => $selection_id) {
                    $advertisement->answers()->where('question_id', $question_id)->update(['selection_id' => $selection_id]);
                }
            }
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('advertisements.show', $advertisement->id);
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        $sub_category= $advertisement->subcategory->id;
        if (auth()->user()->owns($advertisement))
        {
            $advertisement->forceDelete();
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('advertisements.index', ['subcategory_id'=>$sub_category]);
        }
    }
    public function renew($advertisement_id)
    {
        $advertisement =Advertisement::onlyTrashed()->findOrFail($advertisement_id);
        $advertisement->restore();
        $advertisement->update([
            'created_at'=>now()
        ]);
        session()->flash('success',__('site.renewed_successfully'));
        return redirect()->route('advertisements.show',$advertisement_id);
    }
    public function report(Advertisement $advertisement)
    {
        if (!$advertisement->reports()->where('user_id',$advertisement->user->id)->count())
        {
            Report::create([
                'advertisement_id'=>$advertisement->id,
                'user_id'=>$advertisement->user->id
            ]);
            if ($advertisement->check_weight)
            {
                $advertisement->delete();
            }
        }
        return redirect()->route('advertisements.show',$advertisement->id);
    }
    public function markUnavailable(Advertisement $advertisement,Request $request)
    {
        if (auth()->user()->owns($advertisement))
        {
            $request->validate([
                'available_at'=>'required|date_format:Y-m-d|after:today'
            ]);
            $advertisement->update([
                'available_at'=>$request->available_at
            ]);
        }
        return redirect()->route('advertisements.show',$advertisement->id);
    }
    public function markAvailable(Advertisement $advertisement)
    {
        if (auth()->user()->owns($advertisement))
        {
            $advertisement->update([
                'available_at'=>now()
            ]);
        }
        return redirect()->route('advertisements.show',$advertisement->id);
    }
    public function addComment(Request $request)
    {
        if (!auth()->user()->comments()->where('advertisement_id',$request->advertisement)->count())
        {
            $request->validate([
                'rate'=>'required|min:1|max:5',
                'comment'=>'required',
                'advertisement'=>'required'
            ]);
            $comment=Comment::create([
                'rate'=>$request->rate,
                'comment'=>$request->comment,
                'user_id'=>auth()->user()->id,
                'advertisement_id'=>$request->advertisement
            ]);
            return view('advertisements._comment',compact('comment'));
        }
    }
    public function deleteComment(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        if (auth()->user()->id == $comment->user_id) {
            $request->validate([
                'comment_id' => 'required'
            ]);
            if (auth()->user()->id == $comment->user_id) {
                $comment->delete();
            }
        }
    }
    public function updateComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if (auth()->user()->id == $comment->user_id) {
            $request->validate([
                'comment' => 'required'
            ]);
            $request_data = $request->except('id');
            $comment->update($request_data);
        }
    }
}
