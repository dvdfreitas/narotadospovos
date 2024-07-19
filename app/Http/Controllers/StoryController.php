<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'categories'])->latest()->paginate(3);
        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('stories.create', compact('categories'));
    }

    public function show(Story $story)
    {
        return view('stories.show', compact('story'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string', 'max:255'],
            'summary'   => ['required', 'string', 'max:65535'],
            'image'     => [
                'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'date'      => ['required', 'date', 'date_format:Y-m-d'],
            'category_id' => ['nullable', 'array'],
            'categories.*', ['exists:categories,id'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        $validatedData['image'] = $imageName;
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['user_id'] = auth()->id();

        $story = Story::create($validatedData);

        if (isset($validatedData['category_id'])) {
            $story->categories()->attach($validatedData['category_id']);
        }

        return redirect('stories');
    }

    public function edit(Story $story)
    {
        $categories = Category::all();
        return view('stories.edit', compact('story', 'categories'));
    }

    public function update(Request $request, Story $story)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:65535'],
            'image' => [
                'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'category_id' => ['nullable', 'array'],
            'category_id.*' => ['exists:categories,id'],
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['user_id'] = auth()->id();

        $defaulImage = "default.jpg";

        if ($request->hasFile('image')) {

            $currentImaName = $story->image;
            $oldImagePath = public_path('images/' . $currentImaName);

            if ($currentImaName && $currentImaName !== $defaulImage && File::exists(public_path('images/' . $oldImagePath))) {

                File::delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;

        } else {

            $validatedData['image'] = $story->image;
        }

        if (isset($validatedData['category_id']) && is_array($validatedData['category_id'])) {
            $story->categories()->sync($validatedData['category_id']); //Atualizar categoria
        }

        $story->update($validatedData);
        return redirect('/stories/' . $story->slug);
    }
}
