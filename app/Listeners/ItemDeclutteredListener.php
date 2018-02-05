<?php

namespace App\Listeners;

use App\Events\ItemDecluttered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemDeclutteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ItemDecluttered  $event
     * @return void
     */
    public function handle(ItemDecluttered $event)
    {
//       $stories = $event->item->stories()->with('owner')->get();
    }
}
