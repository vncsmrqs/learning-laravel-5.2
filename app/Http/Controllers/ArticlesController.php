<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use Carbon\Carbon;
use App\Http\Requests\CreateArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index()
    {
        $articles = Article::latest('published_at')->published()->get();
        return view('articles.index')->with('articles', $articles);
    }

    public function show(Article $article)
    {
        return view('articles.show')->with('article', $article);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(CreateArticleRequest $request)
    {
        Auth::user()->articles()->create($request->all());

        // session()->flash('flash_message', 'Your article has been added!');
        // session()->flash('flash_message_important', true);

        return redirect('articles')->with([
            'flash_message' =>  'Your article has been added!',
            'flash_message_important' => true
        ]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Article $article, Request $request)
    {
        $article->update($request->all());
        return redirect('articles');
    }
}