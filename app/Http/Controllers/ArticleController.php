<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ArticleService;
use App\Http\Resources\Article as ResourcesArticle;

class ArticleController extends Controller
{
    private $articleService;
    
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResourcesArticle::collection(Article::whereNotNull('published_at')->whereNull('deleted_at')->where('status', 1)->whereDate('published_at',  '<=', Carbon::today()->toDateString())->orderByDesc('published_at')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->articleService->create(new Article, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ResourcesArticle($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        
        if(Auth::user()->id == $article->user_id)
            return $this->articleService->update($article, $request);
        else{
            return response('error', 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if($article->delete())
        {
            return response()->json([
                'success' => 'Article supprimé avec succès'
            ]);
        }
    }
}
