<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Auth;

class ItemController extends Controller
{


    public function create()
    {
        return view('createItem');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'name' => 'required|max:30',
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

        return response()->json([
           'stories' => $stories,
           'isLoggedIn' => $isLoggedIn
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
