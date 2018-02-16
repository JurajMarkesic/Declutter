<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App;

class QuickSortTest extends TestCase
{
    use DatabaseTransactions;

    public function testSortByDate()
    {
        $class = App::make(App\Http\Controllers\StoryController::class);

        $items = App\Item::all();

        $stories = array();

        foreach($items as $item) {
            $itemStories = $item->stories()->get();


            foreach($itemStories as $story) {
                array_push($stories, $story);
            }

        }

        $sorted = $class->quicksortByDate($stories);

        $isSorted = true;

        for($i = 0; $i < count($sorted)-1; $i++) {
            if($sorted[$i]->created_at < $sorted[$i+1]->created_at) {
                $isSorted = false;

                break;
            }
        }

        $this->assertTrue($isSorted);
    }
}
