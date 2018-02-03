<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use Illuminate\Http\Request;
use Auth;

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
