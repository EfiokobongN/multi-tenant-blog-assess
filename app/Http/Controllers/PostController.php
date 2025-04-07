<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\utility\Util;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('approved');
    }

    public  function store(CreatePostRequest $request){
        $user = Util::Auth();

       try {
        
        $imagePath = Util::storeImage($request);
        $createPost = new Post();
        $createPost->user_id = $user->id;
        $createPost->tenant_id = $user->tenant_id;
        $createPost->topic = $request->topic;
        $createPost->content = $request->content;
        $createPost->images = $imagePath;
        $createPost->save();

        return response()->json(['success' => true, 'message' => 'New Post Created Successfully', 'createPost' => $createPost]);
       } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()]);
       }
    }

    public function update(Request $request, Post $post){
        $this->authorize('update', $post);

        $imagePath = Util::storeImage($request);
        $post->topic = $request->topic;
        $post->content = $request->content;
        $post->images = $imagePath ?? $post->images;

        $post->update();

        return response()->json(['success' => true, 'message' => 'Post Updated Successfully', 'createPost' => $post]);
    }
}
