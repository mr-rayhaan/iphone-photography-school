<?php

namespace App\Listeners;

use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LessonWatchedListener
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
    if ($user->lessonsWatched() == 1) {
        $achievement = Achievement::where('name', 'First Lesson Watched')->first();
        $user->unlockAchievement($achievement);
    }
    else if ($user->lessonsWatched() == 5) {
        $achievement = Achievement::where('name', '5 Lessons Watched')->first();
        $user->unlockAchievement($achievement);
    }
    else if ($user->lessonsWatched() == 10) {
        $achievement = Achievement::where('name', '10 Lessons Watched')->first();
        $user->unlockAchievement($achievement);
    }
    else if ($user->lessonsWatched() == 25) {
        $achievement = Achievement::where('name', '25 Lessons Watched')->first();
        $user->unlockAchievement($achievement);
    }
    else if ($user->lessonsWatched() == 50) {
        $achievement = Achievement::where('name', '50 Lessons Watched')->first();
        $user->unlockAchievement($achievement);
    }

    // Check if the user has earned a new badge after unlocking achievements.
    $user->checkBadgeProgress();
    }
}
