<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Comment;
use App\Models\Achievements;
use App\Models\Badges;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $achievementsData = [
            [
                'name' => 'First Lesson Watched',
            ],
            [
                'name' => '5 Lessons Watched',
            ],
            [
                'name' => '10 Lessons Watched',
            ],
            [
                'name' => '25 Lessons Watched',
            ],
            [
                'name' => '50 Lessons Watched',
            ],
            [
                'name' => 'First Comment Written',
            ],
            [
                'name' => '5 Comments Written',
            ],
            [
                'name' => '10 Comments Written',
            ],
            [
                'name' => '25 Comments Written',
            ],
            [
                'name' => '50 Comments Written',
            ],
        ];
        $badgesData = [
            [
                'name' => 'Beginner', 'required_achievements' => 0
            ],
            [
                'name' => 'Intermediate', 'required_achievements' => 4
            ],
            [
                'name' => 'Advanced', 'required_achievements' => 8
            ],
            [
                'name' => 'Master', 'required_achievements' => 10
            ], 
        ];

        Lesson::factory()->count(50)->create(); 
        Comment::factory()->count(5)->create();
        User::factory()->count(5)->create();
        DB::table('achievements')->insert($achievementsData);
        DB::table('badges')->insert($badgesData); 
    }
}
