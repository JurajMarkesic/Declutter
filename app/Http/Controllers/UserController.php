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

    public function edit()
    {
        return view('editprofile')->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'bio' => 'max:600'
        ]);

        $user = Auth::user();

        if($request->has('image')) {
            $image = $request->file('image');

            $imageName = rand(1111, 9999). time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/storage/uploads/');

            $image->move($destinationPath, $imageName);

            $user->image = $imageName;
        }

        if($request->has('bio')) {
            $user->bio = $request->input('bio');

            return response("Bio updated.", 200);
        }

        return redirect()->back()->with('status', "Profile updated!");
    }
}
