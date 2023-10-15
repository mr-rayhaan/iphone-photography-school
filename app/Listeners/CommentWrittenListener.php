<?php

namespace App\Listeners;

use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener
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
        $user = $event->user;

        // Logic to check the user's achievement progress and unlock relevant achievements.
        // Example: Check if the user has written their first comment, then unlock the "First Comment Written" achievement.
        if ($user->commentsWritten() == 1) {
            $achievement = Achievement::where('name', 'First Comment Written')->first();
            $user->unlockAchievement($achievement);
        }
        // Continue with similar logic for other achievements.

        // Check if the user has earned a new badge after unlocking achievements.
        $user->checkBadgeProgress();
    }
}
