<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();
            // $users = User::factory()->count(5)->create();
            $comment = Comment::factory()->count(5)->create();
    }
}
