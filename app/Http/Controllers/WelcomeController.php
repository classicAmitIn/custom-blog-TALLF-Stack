<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('welcome', [
            'featuredArticles' => Article::published()->featured()->with('category')->latest('published_at')->take(3)->get(),
            'latestArticles' => Article::published()->with('user', 'category')->latest('published_at')->take(9)->get(),
        ]);
    }
}
