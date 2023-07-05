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
            'tests' => Test::where('user_id', Auth::id())->with('subject')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tests/Create', [
            'subjects' => Subject::where('user_id', Auth::id())->get(),
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
            $questions = Question::where('subject_id', Request::input('subject'))
                            ->inRandomOrder()
                            ->limit(Request::input('count_questions'))
                            ->pluck('id')
                            ->toArray();

            $test = Test::create([
                'user_id' => Auth::id(),
                'subject_id' => Request::input('subject'),
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

            return Redirect::route('tests.create', $test)->with('errors', $exception->getMessage());
        }

    }

    public function print(Test $test)
    {
        $pdf = Pdf::loadView('pdf.test', ['subject' => $test->subject->name]);
        return $pdf->stream();
    }

    public function answer(Test $test)
    {
        $pdf = Pdf::loadView('pdf.test', ['subject' => $test->subject->name]);
        return $pdf->stream();
    }

    public function show(Test $test)
    {
        return view('pdf.test', ['subject' => $test->subject->name]);
    }
}
