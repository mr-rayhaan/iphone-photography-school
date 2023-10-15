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
    // Example: Check if the user has watched their first lesson, then unlock the "First Lesson Watched" achievement.
    if ($user->lessonsWatched() == 1) {
        $achievement = Achievement::where('name', 'First Lesson Watched')->first();
        $user->unlockAchievement($achievement);
    }
    // Continue with similar logic for other achievements.

    // Check if the user has earned a new badge after unlocking achievements.
    $user->checkBadgeProgress();
    }
}
