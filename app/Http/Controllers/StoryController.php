<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class StoryController extends Controller
{
    /**
     * /noticias: a mais recente e a que está em destaque no topo, e por
     * baixo todas as outras, com páginas e filtro por ano.
     *
     * As duas do topo saem da lista em todas as páginas, e não só na
     * primeira: se saíssem só na primeira, a segunda página começava com
     * uma notícia que já tinha aparecido.
     *
     * Com um ano escolhido não há topo — quem filtra quer a lista.
     */
    public function index(Request $request)
    {
        $years = Story::published()->pluck('date')
            ->map(fn ($date) => (int) substr($date, 0, 4))
            ->unique()
            ->values();

        $year = $years->contains($request->integer('ano')) ? $request->integer('ano') : null;

        $latest = $featured = null;

        if ($year === null && $latest = Story::published()->with('categories')->first()) {
            // A marcada mais recente; sem nenhuma marcada, a segunda mais
            // recente, para o topo não ficar coxo. O is_featured tem de vir
            // antes da data na ordenação, daí o reorder.
            $featured = Story::published()->with('categories')
                ->whereKeyNot($latest->id)
                ->reorder()
                ->orderByDesc('is_featured')
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->first();
        }

        $stories = Story::published()
            ->with('categories')
            ->when($year, fn ($q) => $q->whereYear('date', $year))
            ->whereNotIn('id', array_filter([$latest?->id, $featured?->id]))
            ->paginate(12)
            ->withQueryString();

        return view('stories.index', compact('stories', 'latest', 'featured', 'years', 'year'));
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
            $validatedData['image'] = $imageName;
        }

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

    public function destroy(Story $story)
    {
        $story->delete();
        return redirect('stories/');
    }
}
