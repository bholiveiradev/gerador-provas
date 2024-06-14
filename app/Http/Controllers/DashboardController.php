<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $countSubjects = Subject::whereUserId(Auth::id())->count();
        $countTests = Test::whereUserId(Auth::id())->count();
        $countQuestions = Question::whereHas('subject', function ($query) {
            $query->whereUserId(Auth::id());
        })->count();

        return Inertia::render('Dashboard/Index', compact('countSubjects', 'countQuestions', 'countTests'));
    }
}
