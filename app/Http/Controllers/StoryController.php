<?php

namespace App\Http\Controllers;

use App\Story;
use Illuminate\Http\Request;
use Auth;

class StoryController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|numeric',
            'body' => 'required|max:300',
            'cost' => 'required|numeric'
        ]);

        $story = new Story;

        $story->user_id = Auth::id();
        $story->item_id = (int) $request->input('item_id');
        $story->body = $request->input('body');
        $story->cost = $request->input('cost');

        $story->save();

        return response("Story stored.", 200);
    }


    public function update(Request $request, Story $story)
    {
        $this->validate($request, [
            'body' => 'required|max:200',
            'cost' => 'required|numeric'
        ]);

        $story->body = $request->input('body');
        $story->cost = $request->input('cost');

        $story->update();

        return response("Story updated.", 200);
    }


    public function destroy(Story $story)
    {
        try {
            $story->delete();
            return response("Story deleted.", 200);
        } catch (\Exception $e) {
            report($e);
            return response("Story could not be deleted.", 404);
        }
    }
}
