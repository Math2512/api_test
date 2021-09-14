<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    private $validation;

    public function __construct(AuthenticationRequest $authRequest)
    {
        $this->validation = $authRequest;
    }

    public function register(Request $request){

        $validate = $this->validation->validationAuth($request->all());

        if($validate->fails())
        {
            return response()->json([
                'errors' => $validate->errors()
            ]);

        }else{

            $user = User::create([
                'api_token'=> Str::random(100),
                'email'    => $request->input('email'),
                'name'     => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'remember_token' => Str::random(10),
                'email_verified_at' => now()
            ]);

            return $user;
        }
        
    }

    public function login(Request $request){
        
        $validate = $this->validation->validationAuthLogin($request->all());

        if($validate->fails())
        {
            return response()->json([
                'errors' => $validate->errors()
            ]);

        }else{
        
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
                $user = User::where('email', $request->input('email'))->firstOrFail();
                return $user;
            }else{
                return response()->json('Utilisateur introuvable');
            }
        }
    }
}
