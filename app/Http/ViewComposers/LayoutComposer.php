<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;

class LayoutComposer
{
    public $categories = [];

    public function __construct()
    {
        $this->categories = Category::all();
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