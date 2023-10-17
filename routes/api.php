<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\LessonUser;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Comment;

use App\Events\LessonWatched;
use App\Events\CommentWritten;

use App\Http\Controllers\AchievementsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Route::post('/watch-lesson', function(Request $request) {
    
    $lessonUser = LessonUser::create($request->only([
        'user_id', 'lesson_id', 'watched'
    ]));
    $lesson = Lesson::find($lessonUser->lesson_id);
    $user = User::find($lessonUser->user_id);

    LessonWatched::dispatch($lesson, $user);
});

Route::post('/write-comment', function(Request $request) {

    $comment = Comment::create($request->only([
        'user_id', 'body'
    ])); 
    $user = User::find($comment->user_id);
 
    CommentWritten::dispatch($comment, $user);
});