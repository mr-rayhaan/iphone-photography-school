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
        if ($user->commentsWritten() == 1) {
            $achievement = Achievement::where('name', 'First Comment Written')->first();
            $user->unlockAchievement($achievement);
        }
        else if ($user->commentsWritten() == 5) {
            $achievement = Achievement::where('name', '5 Comments Written')->first();
            $user->unlockAchievement($achievement);
        }
        else if ($user->commentsWritten() == 10) {
            $achievement = Achievement::where('name', '10 Comments Written')->first();
            $user->unlockAchievement($achievement);
        }
        else if ($user->commentsWritten() == 25) {
            $achievement = Achievement::where('name', '25 Comments Written')->first();
            $user->unlockAchievement($achievement);
        }
        else if ($user->commentsWritten() == 50) {
            $achievement = Achievement::where('name', '50 Comments Written')->first();
            $user->unlockAchievement($achievement);
        }

        // Check if the user has earned a new badge after unlocking achievements.
        $user->checkBadgeProgress();
    }
}
