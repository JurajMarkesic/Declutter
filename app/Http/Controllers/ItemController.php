<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use DB;

class ItemController extends Controller
{


    public function create()
    {
        $categories = Category::all();

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

        if($request->has('image')) {
            $image = $request->file('image');

            $imageName = rand(1111, 9999). time() . '.' . $image->getClientOriginalExtension();

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

    public function stories(Item $item)
    {
        $stories = $item->stories()->get();

        $isLoggedIn = Auth::check();

        $alreadyPosted = false;

        foreach($stories as $story) {
            if($story->user_id == Auth::id()) {
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
        if(Auth::user()->decluttered->contains($item)) {
            $isDecluttered = true;
        } else {
            $isDecluttered = false;
        }

        return response()->json([
            'isDecluttered' => $isDecluttered
        ]);
    }

    public function top()
    {
        $declutters = DB::table('items')->orderBy('declutters', 'desc')->take(10)->get();


        $items = Item::all();

        $itemsCost = [];

        foreach($items as $item) {
            $stories = $item->stories()->get();

            $count = $item->stories->count();

            if(!$count) {
                $itemAverage = [$item, 0];

                array_push($itemsCost, $itemAverage);

                continue;
            }

            $total = 0;

            foreach($stories as $story) {
                $total += $story->cost;
            }

            $average = $total / $count;

            $itemAverage = [$item, $average];

            array_push($itemsCost, $itemAverage);
        }

        $sorted = $this->quicksort($itemsCost);

        $itemsByCost = array_slice($sorted, 0, 10);

        return view('top', compact('itemsByCost', 'declutters'));
    }

    private function quicksort($array) //desc
    {
        // find array size
        $length = count($array);

        if($length <= 1){                                // base case test, if array of length 0 then just return array
            return $array;
        } else if($length <= 10) {                       //insertion sort under 10 items
            for($i= 0; $i < count($array); $i++){
                $val = $array[$i];                      //current item

                $j = $i-1;                              //start loop on one item behind the current one

                while($j>=0 && $array[$j][1] < $val[1]){         //stop loop when you reach item's place or the start of an array
                    $array[$j+1] = $array[$j];                    //switch values

                    $j--;
                }

                $array[$j+1] = $val;                //put value in it's current position, no items left off it are smaller
            }

            //return array back to be merged with the rest
            return $array;
        } else{

            // select an item to act as our pivot point, since list is unsorted first position is easiest and you can
            // choose to make the first item something that you suspect would have around median average cost.
            // If it becomes a bottleneck use 3 pivots.
            $pivot = $array[0];

            // declare our two arrays to act as partitions
            $left = $right = array();

            // loop and compare each item in the array to the pivot value, place item in appropriate partition
            for($i = 1; $i < count($array); $i++)
            {
                if($array[$i][1] > $pivot[1]){
                    $left[] = $array[$i];
                }
                else{
                    $right[] = $array[$i];
                }
            }

            // use recursion to now sort the left and right lists
            return array_merge($this->quicksort($left), array($pivot), $this->quicksort($right));
        }
    }


//    public function edit(Item $item)
//    {
//        //
//    }
//
//
//    public function update(Request $request, Item $item)
//    {
//        $this->validate($request, [
//            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
//            'name' => 'required|max:30',
//        ]);
//
//        if($request->has('image')) {
//            $image = $request->file('image');
//
//            $imageName = rand(1111, 9999). time() . '.' . $image->getClientOriginalExtension();
//
//            $destinationPath = public_path('/storage/uploads/');
//
//            $image->move($destinationPath, $imageName);
//
//            $item->image = $imageName;
//        }
//
//        $item->name = $request->input('name');
//
//        $item->update();
//
//        return redirect('/items/' . $item->id);
//    }


//    public function destroy(Item $item)
//    {
//        try {
//            $item->delete();
//            return response("Item deleted.", 200);
//        } catch (\Exception $e) {
//            report($e);
//            return response("Item could not be deleted.", 404);
//        }
//    }
}
