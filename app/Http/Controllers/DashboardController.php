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
        return Inertia::render('Dashboard/Index', [
            'countSubjects' => Subject::where('user_id', Auth::id())->count(),
            'countQuestions' => Question::whereHas('subject', function ($query) {
                $query->where('user_id', Auth::id());
            })->count(),
            'countTests' => Test::where('user_id', Auth::id())->count(),
        ]);
    }
}
