<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::id())
            ->orderBy('name')
            ->paginate(config('pagination.per_page'))
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'deleted_at' => $user->deleted_at,
            ]);

        return Inertia::render('Subjects/Index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Subjects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:100', Rule::unique('subjects')],
        ]);

        $subject = Subject::create([
            'user_id' => Auth::id(),
            'name' => Request::input('name'),
        ]);

        return Redirect::route('subjects.edit', $subject)->with('success', 'Disciplina cadastrada.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $subject->load('questions');

        return Inertia::render('Subjects/Edit', [
            'subject' => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Request::validate([
            'name' => ['required', 'max:100', Rule::unique('subjects')->ignore($subject->id)],
        ]);

        $subject->update(Request::only('name'));

        return Redirect::back()
            ->with('success', 'Disciplina atualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return Redirect::back()->with('success', 'Disciplina removida.');
    }

    public function restore(Subject $subject)
    {
        $subject->restore();

        return Redirect::back()->with('success', 'Disciplina restaurada.');
    }
}
