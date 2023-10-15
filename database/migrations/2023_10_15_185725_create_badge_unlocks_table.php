<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeUnlocksTable extends Migration
{
    public function up()
    {
        Schema::create('badge_unlocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badge_id');
            $table->unsignedBigInteger('user_id');
            // Add any other fields specific to badge unlocks.
            $table->timestamps();

            $table->foreign('badge_id')->references('id')->on('badges');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('badge_unlocks');
    }
}
