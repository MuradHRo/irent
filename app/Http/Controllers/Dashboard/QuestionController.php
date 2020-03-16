<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Question;
use App\Selection;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions=Question::when($request->search,function ($q)use ($request){
            return $q->where('question','like','%'.$request->search.'%');
        })->paginate(5);
        return view('dashboard.questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selections=Selection::all();
        $data = [];
        foreach ($selections as $key => $value) {
            // -> as it return std object
            $data[$value->selector_id][$value->id] = $value->name;
        }
        return view('dashboard.questions.create',compact('data'));
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
            'question'=>'required'
        ]);
        if ($request->selector_id == null)
        {
            Question::create([
                'question'=>$request->question
            ]);
        }
        else
        {
            $question=Question::create([
                'question'=>$request->question
            ]);
            $selections=Selection::all()->where('selector_id',$request->selector_id);
            foreach ($selections as $selection)
            {
                $question->selections()->attach($selection->id);
            }
        }
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.questions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $selections=Selection::all();
        $data = [];
        foreach ($selections as $key => $value) {
            // -> as it return std object
            $data[$value->selector_id][$value->id] = $value->name;
        }
        return view('dashboard.questions.edit',compact('data','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question'=>'required'
        ]);
        if (!$question->selections->isEmpty())
        {
            $question->selections()->detach();
        }
        if ($request->selector_id == null)
        {
            $question->update([
                'question'=>$request->question
            ]);
        }
        else
        {
            $question->update([
                'question'=>$request->question
            ]);
            $selections=Selection::all()->where('selector_id',$request->selector_id);
            foreach ($selections as $selection)
            {
                $question->selections()->attach($selection->id);
            }
        }
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->selections()->detach();
        $question->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.questions.index');
    }
}
