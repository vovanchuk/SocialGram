<?php

namespace App\Http\Controllers;

use App\Entity\User;
use App\Http\Resources\ProfileResource;
use DomainException;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->with('activeStories', 'favoritedStories')->firstOrFail();

        return new ProfileResource($user);
    }

    public function follow($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $auth = Auth::user();

        try {
            $auth->addToFollowing($user);
        } catch (DomainException $e) {
            return response()->json([
                'status' => 'error'
            ], 400);
        }
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function unfollow($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $auth = Auth::user();

        try {
            $auth->removeFromFollowing($user);
        } catch (DomainException $e) {
            return response()->json([
                'status' => 'error'
            ], 400);
        }

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
