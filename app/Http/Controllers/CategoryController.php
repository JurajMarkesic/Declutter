<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Cache;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cache::has('categories:all')) {
            $categories = Cache::get('categories:all');
        } else {
            $categories = Category::all();
            Cache::forever('categories:all', $categories);
        }

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();

        $category->name = $request->input('name');

        $category->save();

        Cache::forget('categories:all');

        return response("Category saved.", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $items = $category->items()->take(10)->get();

        return view('category')->with('items', $items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            Cache::forget('categories:all');
        } catch(\Exception $e) {
            report($e);
            return response("Category not found." , 404);
        }

        return response("Category deleted.", 200);
    }
}
