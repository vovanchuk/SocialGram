<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
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

        Auth::user()->posts()->create([
            'description' => $request['description'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'msg' => 'Post created'
        ], 201);

    }
}
