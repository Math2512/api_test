<?php

namespace Tests\Feature;

use App\Models\Article;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class RouteTest extends TestCase
{
    
    
    public function testUserCanNotAccessArticleIfNotConnected()
    {
        $response = $this->get('/api/article');

        $response->assertStatus(403);
    }

    public function testUserCanAccessArticle()
    {
        $user = Auth::loginUsingId(User::first()->id);
        $response = $this->withHeader('Authorization', $user->api_token)
        ->json('GET', 'api/article');

        $response->assertStatus(200);
    }

    public function testUserCanNotAccessProfileIfNotConnected()
    {
        $response = $this->get('/api/me');

        $response->assertStatus(403);
    }

    public function testUserCanAccessProfile()
    {
        $user = Auth::loginUsingId(User::first()->id);
        $response = $this->withHeader('Authorization', $user->api_token)
        ->json('GET', 'api/me');


        $response->assertStatus(200);
    }

    

    public function testUserCanCreateArticle()
    {
        $user = Auth::loginUsingId(User::first()->id);
        $response = $this->withHeader('Authorization', $user->api_token)
        ->json('POST', 'api/article', [
            'title' => 'test',
            'content' => 'test',
            'status' => 0
        ]);


        $response->assertStatus(201);
    }

    public function testUserCanNotUpdateArticleIfIsNotOwner()
    {
        $user = Auth::loginUsingId(User::first()->id);
        $article = Article::where('user_id', '<>', $user->id)->first();
        $response = $this->withHeader('Authorization', $user->api_token)
        ->json('PATCH', 'api/article/'.$article, [
            'title' => 'test',
            'content' => 'test',
            'status' => 0
        ]);

        $response->assertStatus(404);
        
    }
}
