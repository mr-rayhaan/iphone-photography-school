<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $achievementName = $event->achievementName;
        $user = $event->user;

        // Update user's achievements record
        $user->achievements()->create(['name' => $achievementName]);
    }
}
