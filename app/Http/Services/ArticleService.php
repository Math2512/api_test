<?php

namespace App\Http\Services;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    private $validation;

    public function __construct(ArticleRequest $articleRequest)
    {
        $this->validation = $articleRequest;
    }
    public function create(Article $article, Request $request)
    {
        $validate = $this->validation->validationArticle($request->all());

        if($validate->fails())
        {
            return response()->json([
                'errors' => $validate->errors()
            ]);
        }else{
            if($request->input('status') == 1){
                $article->published_at = new \DateTime();
            }else{
                $article->published_at = $request->input('published_at');
            }
            
            $article->title   = $request->input('title');
            $article->content = $request->input('content');
            $article->published_at = $request->input('published');
            $article->status = $request->input('status');
            $article->user_id = Auth::user()->id;
            $article->save();
            return $article;
        }
    }

    public function update(Article $article, Request $request)
    {   
        
        if($request->input('deleted') == 1)
        {
            $article->deleted_at = new \DateTime();
            $article->update($request->all());
            return $article;
        }
        $validate = $this->validation->validationArticle($request->all());
        if($validate->fails())
        {
            return response()->json([
                'errors' => $validate->errors()
            ]);

        }
        else{
            if($request->input('published_at')){
                $article->status = 1;
                $article->update($request->all());
                return $article;
            }
            
        return $request->all();
            $article->update($request->all());
            return $article;
        }
    }
}