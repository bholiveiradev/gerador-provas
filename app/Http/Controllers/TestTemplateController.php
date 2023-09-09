<?php

namespace App\Http\Controllers;

use App\Models\TestTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TestTemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('Tests/Index', [
            'tests' => TestTemplate::whereUserId(Auth::id())->get(),
        ]);
    }
}
