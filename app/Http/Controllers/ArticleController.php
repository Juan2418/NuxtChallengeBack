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
}
