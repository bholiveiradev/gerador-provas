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
        $subject->questions()->create(
            $request->only('question', 'additional_text')
        );

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
        $question->update(
            $request->only('question', 'additional_text')
        );

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
