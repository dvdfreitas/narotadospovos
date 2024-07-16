<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'categories'])->latest()->get();
        return view('stories.index', compact('stories'));
    }

    public function showCreateForm()
    {
        // Retornar categorias, permintindo a escolha de de categoria a associar a notícia
        $categories = Category::all();
        return view('stories.create', compact('categories'));
    }

    public function show(Story $story)
    {
        return view('stories.show', [
            'story' => $story
        ]);
    }

    public function store(Request $request)
    {
        // Validar os dados de formulário de registo
        $validatedData = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'subtitle'  => ['required', 'string', 'max:255'],
            'summary'   => ['required', 'string', 'max:65535'],
            'image'     => [
                'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'date'      => ['required', 'date', 'date_format:Y-m-d'],
            'categories' => ['required', 'array'],
            'categories.*', ['exists:categories,id'],
        ]);

        // Confirmar se foi anexado a imagem a notícia
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Receber a imagem 
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Gerar nome único da imagem
            $image->move(public_path('images'), $imageName); // Mover para pasta pública
        }

        $user = User::find(1);
        // Caso passe a validação criar notícia 
        $story = Story::create([
            'title'     => $validatedData['title'],
            'user_id' => $user->id,
            'subtitle'  => $validatedData['subtitle'],
            'summary'   => $validatedData['summary'],
            'image'     => $imageName,
            'date'      => $validatedData['date'],
        ]);

        // Associár a notícia as categorias
        if (isset($validatedData['categories'])) {
            $story->categories()->attach($validatedData['categories']);
        }

        // Redirecionar para página notícias
        return redirect('stories');
    }
}
