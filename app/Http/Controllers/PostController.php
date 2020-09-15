<?php

namespace App\Http\Controllers;

use App\Entity\Post;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function store(StoreRequest $request)
    {
        $storePath = public_path("/storage/posts/");

        $imagePath = $request['image']->store('posts', 'public');
        $imagePath = explode('/', $imagePath)[1];

        $image = Image::make($storePath . $imagePath)->resize(1200, 900, function($img) {
            $img->aspectRatio();
            $img->upsize();
        });
        $image->save();

        //make thumbnail for post
        $image->fit(600,600);
        $storePath = public_path("storage/posts_thumbnails/");
        $image->save($storePath . $imagePath);

        $post = Auth::user()->posts()->create([
            'description' => $request['description'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created',
            'post' => new PostResource($post),
        ], 201);
    }

    public function like($post_id)
    {
        $post = Post::find($post_id);
        $user = Auth::user();
        if(!$post) return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
        if($post->likes->contains($user->id)) return response()->json(['status' => 'error', 'message' => 'You are liking this post already'], 400);
        else {
            $post->likes()->attach(Auth::user());
            return response()->json(['status' => 'success', 'message' => 'Success'], 201);
        }
    }

    public function unlike($post_id)
    {
        $post = Post::find($post_id);
        $user = Auth::user();
        if(!$post) return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
        if(!$post->likes->contains($user->id)) return response()->json(['status' => 'error', 'message' => 'You are not liking this post'], 400);
        else {
            $post->likes()->detach(Auth::user());
            return response()->json(['status' => 'success', 'message' => 'Success'], 200);
        }
    }

    public function feed()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return response()->json(['status' => 'success',
                                  'posts' => PostResource::collection($posts)], 200);
    }

}
