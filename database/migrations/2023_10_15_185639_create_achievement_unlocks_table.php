<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementUnlocksTable extends Migration
{
    public function up()
    {
        Schema::create('achievement_unlocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedBigInteger('user_id');
            // Add any other fields specific to achievement unlocks.
            $table->timestamps();

            $table->foreign('achievement_id')->references('id')->on('achievements');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievement_unlocks');
    }
}
