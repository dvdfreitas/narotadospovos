<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        return view('stories.create');
    }
}
