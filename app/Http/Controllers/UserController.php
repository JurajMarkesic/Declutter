<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

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
        $user->followers;
        $user->followings;

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

    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }



    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $this->validate($request,[
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }

    public function toggleFollow($id)
    {
        $followee = User::findOrFail($id);

        $follower = Auth::user();

        if($follower->followings->contains($followee)) {
            $follower->followings()->detach($followee->id);
            $following = false;
        } else {
            $follower->followings()->attach($followee->id);
            $following = true;
        }

        return response()->json([
           'following' => $following
        ]);
    }

    public function checkFollow($id)
    {
        $followee = User::findOrFail($id);

        $follower = Auth::user();

        if($follower->followings->contains($followee)) {
            $isFollowing = true;
        } else {
            $isFollowing = false;
        }

        return response()->json([
                'isFollowing' => $isFollowing
            ]);
    }

    public function getFollowers()
    {
        $user = Auth::user();

        $followers = $user->followers()->get();

        return view('followers')->with('followers',$followers);
    }

    public function getFollowings()
    {
        $user = Auth::user();

        $followings = $user->followings()->get();

        return view('followings')->with('followings', $followings);
    }
}
