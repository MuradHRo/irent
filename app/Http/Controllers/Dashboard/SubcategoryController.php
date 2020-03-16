<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Question;
use App\subcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subcategories=Subcategory::when($request->search,function ($q) use ($request){
            return $q->where('name','like','%'.$request->search.'%');
        })->when($request->category_id,function ($q) use ($request){
            return $q->where('category_id',$request->category_id);
        })->latest()->paginate(5);
        $categories=Category::all();
        return view('dashboard.subcategories.index',compact('subcategories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $questions=Question::all();
        return view('dashboard.subcategories.create',compact('categories','questions'));
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
            'category_id'=>'required',
            'name'=>'required|unique:subcategories,name',
            'icon'=>'required',
            'question_ids'=>'array|required'
        ]);
        $subcategory=Subcategory::create($request->all());
        foreach ($request->question_ids as $question_id)
        {
            $subcategory->questions()->attach($question_id);
        }
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.subcategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(subcategory $subcategory)
    {
        $categories=Category::all();
        $questions=Question::all();
        return view('dashboard.subcategories.edit',compact('subcategory','categories','questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subcategory $subcategory)
    {
        $request->validate([
            'category_id'=>'required',
            'name'=>['required',Rule::unique('subcategories')->ignore($subcategory->id)],
            'icon'=>'required',
            'question_ids'=>'array|required'
        ]);
        $subcategory->update($request->all());
        $subcategory->questions()->sync($request->question_ids);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(subcategory $subcategory)
    {
        $subcategory->delete();
        $subcategory->questions()->detach();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.subcategories.index');
    }
}
