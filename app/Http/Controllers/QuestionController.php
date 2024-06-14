<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request, Subject $subject)
    {
        $data = $request->only('question', 'additional_text');

        $subject->questions()->create($data);

        return Redirect::route('subjects.edit', $subject)
                        ->with('success', 'Questão adicionada.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $question->load(['subject', 'answers']);

        return Inertia::render('Questions/Edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->only('question', 'additional_text');

        $question->update($data);

        return Redirect::back()->with('success', 'Questão atualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return Redirect::back()->with('success', 'Questão removida.');
    }
}
