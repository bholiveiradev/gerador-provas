<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class AnswerController extends Controller
{
    public function store(Question $question)
    {
        Request::validate([
            'answer' => ['required'],
            'is_correct' => ['required', 'boolean'],
        ]);

        if (
            Request::input('is_correct') &&
            $question->answers()->whereIsCorrect(true)->count() >= 1
        ) {
            return Redirect::route('questions.edit', $question)
                            ->with('error', 'É permitido apenas uma resposta correta.');
        }

        $question->answers()->create(Request::only('answer', 'is_correct'));

        return Redirect::route('questions.edit', $question)
                        ->with('success', 'Resposta adicionada.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return Redirect::back()->with('success', 'Resposta removida.');
    }
}
