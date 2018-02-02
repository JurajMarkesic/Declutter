<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function getUserById($id)
    {
        $user = User::findOrFail($id);

        $isUsersStory = $user == Auth::user();

        return response()->json(['user' => $user, 'isUsersStory' => $isUsersStory]);
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);


        $isUser = $user == Auth::user();

        $user->stories;

        $isPublic = $user->public;

        return view('userprofile', compact('user', 'isUser', 'isPublic'));
    }
}
