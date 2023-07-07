<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Throwable;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Tests/Index', [
            'tests' => Test::whereUserId(Auth::id())->with('subject')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tests/Create', [
            'subjects' => Subject::whereUserId(Auth::id())->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        Request::validate([
            'subject' => ['required', 'exists:questions,subject_id'],
            'count_questions' => ['required', 'numeric', 'min:1'],
        ], ['subject.exists' => 'Não há questões cadastradas para a disciplina selecionada']);

        DB::beginTransaction();

        try {
            $questions = Question::whereSubjectId(Request::input('subject'))
                            ->inRandomOrder()
                            ->limit(Request::input('count_questions'))
                            ->pluck('id')
                            ->toArray();

            $test = Test::create([
                'user_id' => Auth::id(),
                'subject_id' => Request::input('subject'),
                'infos' => Request::input('infos'),
                'count_questions' => count($questions) >= Request::input('count_questions')
                                        ? Request::input('count_questions')
                                        : count($questions),
            ]);

            $test->questions()->sync($questions);

            DB::commit();

            return Redirect::route('tests.create')
                ->with('success', 'Prova gerada com sucesso.');

        } catch (Throwable $exception) {

            DB::rollBack();

            return Redirect::back()->with('errors', $exception->getMessage());
        }

    }

    public function show(int $id)
    {
        $test = Test::whereId($id)
                    ->with(['subject', 'questions'])
                    ->whereHas('questions')
                    ->first();

        return view('pdf.test', compact('test'));
    }

    public function print(int $id)
    {
        $test = Test::whereId($id)
                    ->with(['subject', 'questions'])
                    ->whereHas('questions')
                    ->first();

        return Pdf::loadView('pdf.test', compact('test'))->stream();
    }

    public function answer(int $id)
    {
        $test = Test::whereId($id)
                    ->with(['subject', 'questions'])
                    ->whereHas('questions')
                    ->first();

        return Pdf::loadView('pdf.answer', compact('test'))->stream();
    }
}
