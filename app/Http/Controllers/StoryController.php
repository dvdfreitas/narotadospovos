<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
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
            'categories.*', ['exists:categories,id'],
        ]);

        // Confirmar se foi anexado a imagem a notícia
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Receber a imagem 
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Gerar nome único da imagem
            $image->move(public_path('images'), $imageName); // Mover para pasta pública
        }
        
        // Add slug to the validated data
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['user_id'] = auth()->id();

        // Caso passe a validação criar notícia 
        $story = Story::create($validatedData);

        // Associár a notícia as categorias
        if (isset($validatedData['categories'])) {
            $story->categories()->attach($validatedData['categories']);
        }

        // Redirecionar para página notícias
        return redirect('stories');
    }
}
