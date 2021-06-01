<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::where('user_id', '=', Auth::user()->id)->get();
    }

    public function get(Article $article) {
        if ($article->user_id !== Auth::user()->id) {
            return response('You are not authorized to read this article', 503);
        }
        return $article;
    }
}
