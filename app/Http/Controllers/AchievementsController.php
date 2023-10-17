<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AchievementsController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->user);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        // The name of the tables
        $achievementsTable = 'achievements';
        $badgesTable = 'badges';

        if (!Schema::hasTable($achievementsTable) || !Schema::hasTable($badgesTable)) {
            // The table does not exist
            return env('APP_ENV') === 'local' ?
                response()->json(['success' => false, 'message' => 'Please run the migration command'], 404)
                :
                response()->json(['success' => false, 'message' => 'Something went wrong'], 404);
        } else if (DB::table($achievementsTable)->count() === 0 || DB::table($badgesTable)->count() === 0) {
            // The table is empty
            return env('APP_ENV') === 'local' ?
                response()->json(['success' => false, 'message' => 'Please seed the tables using {php artisan db:seed}'], 404)
                :
                response()->json(['success' => false, 'message' => 'Something went wrong'], 404);
        }

        $unlockedAchievements = $user->achievements->pluck('name')->toArray();
        $nextAvailableAchievements = $user->getNextAvailableAchievements();
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
