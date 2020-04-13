<?php

namespace App\Http\Controllers\Dashboard;

use App\Advertisement;
use App\Answer;
use App\Http\Controllers\Controller;
use App\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_advertisements'])->only('index');
        $this->middleware(['permission:create_advertisements'])->only('create','store');
        $this->middleware(['permission:update_advertisements'])->only('update','edit');
        $this->middleware(['permission:delete_advertisements'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $advertisements=Advertisement::when($request->search,function ($q) use ($request){
            return $q->where('name','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.advertisements.index',compact('advertisements'));
    }

    public function show(Advertisement $advertisement)
    {
        $answers=$advertisement->answers;
        return view('dashboard.advertisements.show',compact('answers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategories=Subcategory::all();
        return view('dashboard.advertisements.create',compact('subcategories'));
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
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.advertisements.index');
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
        return view('dashboard.advertisements.edit',compact('advertisement','subcategories','answers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Respo nse
     */
    public function update(Request $request, Advertisement $advertisement)
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

        // Image
        if ($request->hasFile('image')) {
            foreach (explode(',', $advertisement->image) as $image) {
                if ($image != 'default.png') {
                    Storage::disk('public_uploads')->delete('/advertisement_images/' . $image);
                }
            }

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
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image != 'default.png')
        {
            Storage::disk('public_uploads')->delete('/advertisement_images/'.$advertisement->image);
        }
        $advertisement->forceDelete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.advertisements.index');
    }

    public function getquestions(Request $request)
    {
        $questions=Subcategory::find($request->subcategory_id)->questions;
        return view('dashboard.advertisements._questions',compact('questions'));
    }
}
