<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text'    => 'required|string|max:512',
            'post_id' => 'required|integer|min:0'
        ]);

        $comment = Auth::user()->comments()->create([
            'post_id' => $validated['post_id'],
            'text'    => $validated['text']
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Comment created!',
            'comment' =>  new CommentResource($comment)], 201);
    }

//    public function report(Request $request)
//    {
//        $validated = $request->validate([
//            'comment_id' => 'required|integer|min:0'
//        ]);
//
//        $report = CommentReport::create([
//            'user_id' => Auth::id(),
//            'comment_id' => $validated['comment_id']
//        ]);
//
//        return response('OK', 200);
//    }
}
