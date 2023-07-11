<?php

namespace App\Http\Controllers;

use App\Models\TestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TestModelController extends Controller
{
    public function index()
    {
        return Inertia::render('Tests/Index', [
            'tests' => TestModel::whereUserId(Auth::id())->get(),
        ]);
    }
}
