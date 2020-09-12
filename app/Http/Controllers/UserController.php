<?php

namespace App\Http\Controllers;

use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(
            [
                'status' => 'success',
                'users'  => $users->toArray()
            ], 200);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json(
            [
                'status' => 'success',
                'user'   => $user->toArray()
            ], 200);
    }

    public function update(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if ($request['image']) {
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
        if ($request['oldPassword']) {
            $validated = $request->validate(['oldPassword' => 'string|min:3|max:16',
                                             'newPassword' => 'string|min:3|max:16|confirmed']);

            if (Hash::check($validated['oldPassword'], $user->password)) {
                $user->password = bcrypt($validated['newPassword']);
                $user->save();

                return response()->json(['status' => 'success', 'message' => 'Password changed'], 200);
            } else return response()->json(['status' => 'error', 'message' => 'Old password incorrent'], 400);
        } else {
            $validated = $request->validate(['username'    => 'string|alpha_dash|max:16|min:4|unique:users,username,' . $user->id,
                                             'title'       => 'string|alpha_spaces|min:4|max:32',
                                             'url'         => 'url',
                                             'description' => 'string|max:255']);
            $user->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Information updated'
            ], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Oops'], 401);
    }
}
