<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\User;

class ApiController extends Controller
{
    public function posts()
    {
        return PostResource::collection(Post::all());
    }

    public function new(PostRequest $request)
    {
        Post::create([
            'text' => $request->text,
            'email' => $request->email,
            'user_id' => User::query()
                ->where('email', $request->email)
                ->first()
                ->id,
        ]);
    }
}
