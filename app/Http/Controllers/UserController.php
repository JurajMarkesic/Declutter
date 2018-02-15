<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use Cache;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' =>['searchUsers', 'edit', 'update', 'changePassword',
            'toggleFollow','toggleVisibility','showAdmin','destroy']]);
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        $users = User::search($query)->get();

        return response()->json([
            'users' => $users
        ]);
    }
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

        if(Cache::has('user:full:'.$user->id)) {
            $user = Cache::get('user:full:'.$user->id);
        }else {
            $user->load('stories.item');
            $user->followers;
            $user->followings;
            Cache::forever('user:full:'.$user->id, $user);
        }

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

            $user->update();

            Cache::forget('user:full:' . Auth::id());

            return response("Bio updated.", 200);
        }

        $user->update();

        Cache::forget('user:full:' . Auth::id());


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

        Cache::forget('user:follows:'.$follower->id);
        Cache::forget('user:following:'.$followee->id);

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

    public function getFollowers()  //returns users who follow currently authenticated user
    {
        $user = Auth::user();

        if(Cache::has('user:following:'.$user->id)) {
            $followers = Cache::get('user:following:'.$user->id);
        }else {
            $followers = $user->followers()->get();
            Cache::forever('user:following:'.$user->id, $followers);
        }

        return view('followers')->with('followers',$followers);
    }

    public function getFollowings()  //returns users who currently authenticated user follows
    {
        $user = Auth::user();

        if(Cache::has('user:follows:'.$user->id)) {
            $followings = Cache::get('user:follows:'.$user->id);
        }else {
            $followings = $user->followings()->get();
            Cache::forever('user:follows:'.$user->id, $followings);
        }

        return view('followings')->with('followings', $followings);
    }


    public function toggleVisibility()
    {
        $user = Auth::user();

        $user->public = !$user->public;

        $user->update();

        return response("Visibility changed.", 200);
    }


    public function showAdmin()
    {
        return view('admin');
    }

    public function checkLogIn(User $user)
    {
        if($user === Auth::user()) {
            return true;
        }
        return false;
    }

    public function averageCost(User $user)  //returns average cost of items user decluttered
    {
        if(Cache::has('user:cost:'.$user->id)) {
            $cost = Cache::get('user:cost:'.$user->id);
        } else {
            $stories = $user->stories()->get();

            $total = 0;

            $count = 0;

            foreach($stories as $story) {
                $count++;
                $total += $story->cost;
            }

            $cost = $total / $count;

            Cache::forever('user:cost:'.$user->id, $cost);
        }

        return response()->json(['cost' => $cost]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch(\Exception $e) {
            report($e);

            return response("User not found.", 404);
        }

        return response("User deleted.", 200);
    }
}
