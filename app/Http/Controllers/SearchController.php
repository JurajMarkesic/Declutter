<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class SearchController extends Controller
{
    public function searchItems(Request $request)
    {
        $query = $request->input('query');

        $result = Item::search($query)->get();

        return view('result')->with('result', $result);
    }
}
