<?php

namespace App\Http\Controllers;

use App\Entity\User;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ], 200);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    public function update(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if($request['image']) {
            $request->validate(['image' => 'image|max:8192']);
            $path = $request['image']->store('profiles', 'public');
            $path = explode('/', $path)[1];

            Image::make(public_path('storage/profiles/') . $path)->widen(300)->save();
            $user->image = $path;
            $user->save();

            return response()->json([
                'status' => 'success',
                'avatar' => $user->avatar
            ], 200);
        }
    }
}
