<?php

namespace App\Listeners;

use App\Events\UserProfileCreated;
use App\Models\Profile;

class CreateProfile
{
    /**
     * Handle the event.
     *
     * @param  UserProfileCreated  $event
     * @return void
     */
    public function handle(UserProfileCreated $event)
    {
        // Create a profile for the newly registered user
        $profile = new Profile();
        $profile->userID = $event->user->id;
        // Add any additional fields you want to populate
        $profile->save();
    }
}
    