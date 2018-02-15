<?php

namespace App\Http\Controllers;

use App\Events\ItemDecluttered;
use App\Item;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use DB;
use Cache;
use Illuminate\Support\Facades\Redis;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create','store','declutter','undoDeclutter']]);
    }

    public function create()
    {
        if(Cache::has('categories:all')) {
            $categories = Cache::get('categories:all');
        } else {
            $categories = Category::all();
            Cache::forever('categories:all', $categories);
        }

        return view('createItem')->with('categories', $categories);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'name' => 'required|max:30',
            'category' => 'required|numeric'
        ]);

        $item = new Item;

        if ($request->has('image')) {
            $image = $request->file('image');

            $imageName = rand(1111, 9999) . time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/storage/uploads/');

            $image->move($destinationPath, $imageName);

            $item->image = $imageName;
        }

        $item->name = $request->input('name');

        $item->category_id = $request->input('category');

        $item->save();

        return redirect('/items/' . $item->id);
    }


    public function show(Item $item)
    {
        $item->stories;
        return view('item')->with('item', $item);
    }

    public function stories(Item $item)  //returns all stories for a certain item
    {
        $stories = $item->stories()->get();

        $isLoggedIn = Auth::check();

        $alreadyPosted = false;

        foreach ($stories as $story) {
            if ($story->user_id == Auth::id()) {
                $alreadyPosted = true;
            }
        }

        return response()->json([
            'stories' => $stories,
            'isLoggedIn' => $isLoggedIn,
            'alreadyPosted' => $alreadyPosted
        ]);
    }

    public function declutter(Item $item)
    {
        $user = Auth::user();

        $user->declutters++;

        $item->declutters++;

        $user->update();
        $item->update();

        $user->decluttered()->attach($item->id);

//        event(new ItemDecluttered($item));

        return response("Item declutterd.", 200);
    }

    public function undoDeclutter(Item $item)
    {
        $user = Auth::user();

        $user->declutters--;

        $item->declutters--;

        $user->update();
        $item->update();

        $user->decluttered()->detach($item->id);

        return response("Item declutter undid.", 200);
    }

    public function checkDeclutter(Item $item)
    {
        if (Auth::check()) {
            $isLoggedIn = true;

            if (Auth::user()->decluttered->contains($item)) {
                $isDecluttered = true;
            } else {
                $isDecluttered = false;
            }

        } else {
            $isLoggedIn = false;
            $isDecluttered = true;
        }



        return response()->json([
            'isDecluttered' => $isDecluttered,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function top()   //returns top items by declutters and cost
    {
        if(Cache::has('top:items:declutters')) {
            $declutters = Cache::get('top:items:declutters');
        }else {
            $declutters = DB::table('items')->orderBy('declutters', 'desc')->take(5)->get(); //gets top 5 items by declutters
            Cache::put('top:items:declutters', $declutters, 60);
        }


        if (Cache::has('top:items:cost')) {              //gets top 5 items by average cost. N*M.
            $itemsByCost = Cache::get('top:items:cost');
        } else {
            $items = Item::with('stories')->get();

            $itemsCost = [];

            foreach ($items as $item) {
                $stories = $item->stories;

                $count = $item->stories->count();

                if (!$count) {
                    $itemAverage = [$item, 0];

                    array_push($itemsCost, $itemAverage);

                    continue;
                }

                $total = 0;

                foreach ($stories as $story) {
                    $total += $story->cost;
                }

                $average = $total / $count;

                $itemAverage = [$item, $average];

                array_push($itemsCost, $itemAverage);
            }

            $sorted = $this->quicksortByCost($itemsCost);         //sorts all items by the average cost of their stories

            $itemsByCost = array_slice($sorted, 0, 5);  //takes top 5 items

            Cache::put('top:items:cost', $itemsByCost, 60);
        }



        return view('top', compact('itemsByCost', 'declutters'));
    }

    private function quicksortByCost($array) //desc
    {
        // find array size
        $length = count($array);

        if ($length <= 1) {                                // base case test, if array of length 0 then just return array
            return $array;
        } else if ($length <= 10) {                       //insertion sort under 10 items
            for ($i = 0; $i < count($array); $i++) {
                $val = $array[$i];                      //current item

                $j = $i - 1;                              //start loop on one item behind the current one

                while ($j >= 0 && $array[$j][1] < $val[1]) {         //stop loop when you reach item's place or the start of an array
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
                if ($array[$i][1] > $pivot[1]) {
                    $left[] = $array[$i];
                } else {
                    $right[] = $array[$i];
                }
            }

            // use recursion to now sort the left and right lists
            return array_merge($this->quicksortByCost($left), array($pivot), $this->quicksortByCost($right));
        }
    }

}