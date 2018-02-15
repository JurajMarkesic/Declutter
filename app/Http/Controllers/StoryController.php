<?php

namespace App\Http\Controllers;

use App\Story;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Cache;

class StoryController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|numeric',
            'body' => 'required|max:600',
            'cost' => 'required|numeric'
        ]);

        $story = new Story;

        $story->user_id = Auth::id();
        $story->item_id = (int) $request->input('item_id');
        $story->body = $request->input('body');
        $story->cost = $request->input('cost');

        $story->save();

        Cache::forget('user:full:' . Auth::id());
        Cache::forget('user:stories:'.Auth::id());
        Cache::forget('user:cost:' . Auth::id());

        return response("Story stored.", 200);
    }


    public function update(Request $request, Story $story)
    {
        $this->validate($request, [
            'body' => 'required|max:600',
            'cost' => 'required|numeric'
        ]);

        $story->body = $request->input('body');
        $story->cost = $request->input('cost');

        $story->update();

        Cache::forget('user:full:' . Auth::id());
        Cache::forget('user:cost:' . Auth::id());

        return response("Story updated.", 200);
    }

    public function getUserStories(User $user)
    {
        if(Cache::has('user:stories'.$user->id)) {
            $stories = Cache::get('user:stories'.$user->id);
        }else {
            $stories = $user->stories()->with('item')->orderBy('created_at', 'DESC')->paginate(6);
            Cache::forever('user:stories'.$user->id, $stories);
        }

        return response()->json(['stories' => $stories]);
    }


    public function destroy(Story $story)
    {
        try {
            $story->delete();

            Cache::forget('user:full:'.Auth::id());
            Cache::forget('user:stories:'.Auth::id());
            Cache::forget('user:cost:' . Auth::id());

            return response("Story deleted.", 200);
        } catch (\Exception $e) {
            report($e);
            return response("Story could not be deleted.", 404);
        }
    }
}
