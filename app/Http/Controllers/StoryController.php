<?php

namespace App\Http\Controllers;

use App\Story;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Cache;

class StoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['sore','update','destroy']]);
    }

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

    public function getUserStories(User $user)  //returns and caches all stories created by the user
    {
        if(Cache::has('user:stories'.$user->id)) {
            $stories = Cache::get('user:stories'.$user->id);
        }else {
            $stories = $user->stories()->with('item')->orderBy('created_at', 'DESC')->paginate(6);
            Cache::forever('user:stories'.$user->id, $stories);
        }

        return response()->json(['stories' => $stories]);
    }


    public function getFolloweeStories()  //get sorted stories from the people you follow. Displayed on /home
    {
        $user = Auth::user();

        if(Cache::has('follow:stories:'.$user->id)) {
            $stories = Cache::get('follow:stories:'.$user->id);
        } else {
            $followings = $user->followings()->with('stories')->get();

            $storiesAll = array();

            foreach($followings as $followee) {
                $latestStories = $followee->stories()->latest()->take(10)->get();

                foreach($latestStories as $stry) {
                    array_push($storiesAll, $stry);
                }
            }

            $storiesAll = $this->quicksortByDate($storiesAll);  //sorts all stories in desc order


            $stories = array_slice($storiesAll, 0,15);  //takes only the latest 15

            foreach($stories as $stry) {
                $stry->load(['owner', 'item']); //horrible
            }

            Cache::put('follow:stories:'.$user->id, $stories, 1);
        }

        return response()->json([
            'stories' => $stories
        ]);
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



    private function quicksortByDate($array) {
        // find array size
        $length = count($array);

        if ($length <= 1) {                                // base case test, if array of length 0 then just return array
            return $array;
        } else if ($length <= 10) {                       //insertion sort under 10 items
            for ($i = 0; $i < count($array); $i++) {
                $val = $array[$i];                      //current item

                $j = $i - 1;                              //start loop on one item behind the current one

                while ($j >= 0 && $array[$j]->created_at < $val->created_at) {         //stop loop when you reach item's place or the start of an array
                    $array[$j + 1] = $array[$j];                    //switch values

                    $j--;
                }

                $array[$j + 1] = $val;                //put value in it's current position, no items left off it are smaller
            }

            //return array back to be merged with the rest
            return $array;
        } else {

            // select an item to act as our pivot point, since list is unsorted first position is easiest and you can
            // choose to make the first item something that you suspect would have around median average cost.
            // If it becomes a bottleneck use 3 pivots.
            $pivot = $array[0];

            // declare our two arrays to act as partitions
            $left = $right = array();

            // loop and compare each item in the array to the pivot value, place item in appropriate partition
            for ($i = 1; $i < count($array); $i++) {
                if ($array[$i]->created_at > $pivot->created_at) {
                    $left[] = $array[$i];
                } else {
                    $right[] = $array[$i];
                }
            }

            // use recursion to now sort the left and right lists
            return array_merge($this->quicksortByDate($left), array($pivot), $this->quicksortByDate($right));
        }
    }
}
