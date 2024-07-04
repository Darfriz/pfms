<?php

namespace App\Listeners;

use App\Models\Profile; // Adjust the namespace
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateProfile
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Create the user's profile
        Profile::create([
            'userID' => $event->user->id,
            
            // Add other profile data here
        ]);
    }
}
