<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class AuthenticationRequest
{
    function validationAuth($inputs)
    {
        $rules =  [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
            'name' => 'required|max:255',
        ];

        $messages = [
            'email.required'=> 'L\'email est obligatoire',
            'email.email'=> 'L\'email doit avoir un format valide',
            'password.required'=> 'Le mot de passe est obligatoire',
            'name.required'=> 'Le nom est obligatoire'
        ];
    
        return $this->validateAuth($inputs, $rules, $messages);
    
    }

    function validationAuthLogin($inputs)
    {
        $rules =  [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ];

        $messages = [
            'email.required'=> 'L\'email est obligatoire',
            'email.email'=> 'L\'email doit avoir un format valide',
            'password.required'=> 'Le mot de passe est obligatoire',
        ];
    
        return $this->validateAuth($inputs, $rules, $messages);
    
    }
    
    function validateAuth($inputs, array $rules, array $messages)
    {
        $validator = Validator::make($inputs, $rules, $messages);

        return $validator;
    }
}
