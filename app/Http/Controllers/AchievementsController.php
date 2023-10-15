<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();
        $nextAvailableAchievements = $user->getNextAvailableAchievements(); // Implement this method in the User model.
        $currentBadge = $user->getCurrentBadge();
        $nextBadge = $user->getNextBadge();
        $remainingToUnlockNextBadge = $user->remainingAchievementsToUnlockNextBadge();

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }
}
