<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class ArticleRequest
{
        
    function validationArticle($inputs)
    {
        $rules =  [
            'title'   => 'required|min:2|max:128',
            'content' => 'required'
        ];

        $messages = [
            'title.required'=> 'Le titre est obligatoire',
            'title.max'=> 'Le titre doit faire moins de 128 charactères',
            'title.min'=> 'Le titre doit faire au moins 2 charactères',
            'content.required'=> 'Le contenu est obligatoire'
        ];
    
        return $this->validateArticle($inputs, $rules, $messages);
    
    }
    
    function validateArticle($inputs, array $rules, array $messages)
    {
        $validator = Validator::make($inputs, $rules, $messages);

        return $validator;
        
    }
}
