<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Article as ResourcesArticle;

class ProfilController extends Controller
{
    public function index()
    {
        return ResourcesArticle::collection(Article::where('user_id', Auth::user()->id)->whereNull('deleted_at')->orderByDesc('published_at')->get());
    }
}
