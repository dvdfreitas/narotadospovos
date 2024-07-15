<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'categories'])->get();
        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        return view('stories.create');
    }

    public function show(Story $story)
    {
        return view('stories.show', [
            'story' => $story
        ]);
    }
}
