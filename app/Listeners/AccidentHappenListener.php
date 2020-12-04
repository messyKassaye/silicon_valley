<?php

namespace App\Listeners;

use App\Events\AccidentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccidentHappenListener
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
     * @param  AccidentEvent  $event
     * @return void
     */
    public function handle(AccidentEvent $event)
    {
        //
    }
}
