<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_users', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->required();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('lesson_id')->required();
            $table->foreign('lesson_id')->references('id')->on('lessons');

            $table->unsignedInteger('watched')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_users');
    }
};
