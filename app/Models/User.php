<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    public function lessonsWatched()
    {
        // Logic to count the number of lessons watched by the user.
        return $this->lessons->count();
    }

    public function commentsWritten()
    {
        // Logic to count the number of comments written by the user.
        return $this->comments->count();
    }

    public function unlockAchievement($achievement)
    {
        // Logic to unlock an achievement for the user.
        $this->achievements()->attach($achievement);
        event(new AchievementUnlocked($achievement->name, $this));
    }

    public function checkBadgeProgress()
    {
        // Logic to check if the user has earned a new badge and unlock it.
        $achievementCount = $this->achievements->count();

        if ($achievementCount >= 10) {
            $this->unlockBadge('Master');
        } elseif ($achievementCount >= 8) {
            $this->unlockBadge('Advanced');
        } elseif ($achievementCount >= 4) {
            $this->unlockBadge('Intermediate');
        } elseif ($achievementCount >= 0) {
            $this->unlockBadge('Beginner');
        }
    }

    public function unlockBadge($badgeName)
    {
        // Logic to unlock a badge for the user.
        $badge = Badge::where('name', $badgeName)->first();
        if ($badge) {
            $this->badges()->sync([$badge->id]);
            event(new BadgeUnlocked($badge->name, $this));
        }
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_unlocks');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_unlocks');
    }

    public function getNextAvailableAchievements()
    {
        // Logic to fetch the next available achievements for the user.
        // Example: If the user has unlocked "First Lesson Watched" and "First Comment Written,"
        // the next available achievements are "5 Lessons Watched" and "3 Comments Written."
        $unlockedAchievements = $this->achievements->pluck('name')->toArray();

        $nextAvailableAchievements = Achievement::whereNotIn('name', $unlockedAchievements)->pluck('name')->toArray();

        return $nextAvailableAchievements;
    }

    public function getCurrentBadge()
    {
        // Logic to fetch the current badge for the user.
        $badgeUnlock = $this->badges->first();
        return $badgeUnlock ? $badgeUnlock->name : 'Beginner';
    }

    public function getNextBadge()
    {
        // Logic to fetch the next badge for the user.
        $badge = $this->badges->first();
        if (!$badge) {
            return 'Beginner';
        }

        $badgeNames = Badge::pluck('name')->toArray();
        $currentBadgeIndex = array_search($badge->name, $badgeNames);

        return isset($badgeNames[$currentBadgeIndex + 1]) ? $badgeNames[$currentBadgeIndex + 1] : null;
    }

    public function remainingAchievementsToUnlockNextBadge()
    {
        // Logic to calculate the number of additional achievements needed to earn the next badge.

        $achievementCount = 0;
        if ($this->achievements !== null) {
            $achievementCount = $this->achievements->count();
        } else {
            // Handle the case where achievements is null
        }
        $nextBadge = $this->getNextBadge();

        if (!$nextBadge) {
            return 0; // User has already unlocked the highest badge.
        }
        return 0;
        $nextBadgeAchievementCount = Badge::where('name', $nextBadge)->first()->achievements->count();
        return $nextBadgeAchievementCount - $achievementCount;
    }
}
