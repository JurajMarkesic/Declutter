<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;
use Cache;

class LayoutComposer
{
    public $categories = [];


    public function __construct()
    {
        if(Cache::has('categories:all')) {
            $this->categories = Cache::get('categories:all');
        } else {
            $this->categories = Category::all();
            Cache::forever('categories:all', $this->categories);
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories);
    }
}