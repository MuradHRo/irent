<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Selection;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_selections'])->only('index');
        $this->middleware(['permission:create_selections'])->only('create','store');
        $this->middleware(['permission:update_selections'])->only('update','edit');
        $this->middleware(['permission:delete_selections'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selections=Selection::all();
        $data = [];
        foreach ($selections as $selection) {
            // -> as it return std object
            $data[$selection->selector_id][$selection->id] = $selection->name;
        }
        dd($data);
        return view('dashboard.selections.index',compact('data','selections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.selections.create');
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
            'selection'=>'array|required|min:2'
        ]);
        if (Selection::count())
        {
            $selector_id= Selection::max('selector_id')+1;
        }
        else
        {
            $selector_id=0;
        }
        foreach ($request->selection as $selection)
        {
            Selection::create([
               'name'=>$selection,
                'selector_id'=>$selector_id
            ]);
        }
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.selections.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function show(Selection $selection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function edit($selector_id)
    {
        $selections=Selection::all()->where('selector_id',$selector_id);
        return view('dashboard.selections.edit',compact('selections','selector_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$selector_id)
    {
        $request->validate([
            'selection'=>'array|required|min:2'
        ]);
        $selections=Selection::all()->where('selector_id',$selector_id);
        foreach ($selections as $selection)
        {
            $selection->delete();
        }
        if (Selection::count())
        {
            $selector_id= Selection::max('selector_id')+1;
        }
        else
        {
            $selector_id=0;
        }
        foreach ($request->selection as $selection)
        {
            Selection::create([
                'name'=>$selection,
                'selector_id'=>$selector_id
            ]);
        }
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.selections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function destroy($selector_id)
    {
        $selections=Selection::all()->where('selector_id',$selector_id);
        foreach ($selections as $selection)
        {
            $selection->delete();
        }
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.selections.index');
    }
}
