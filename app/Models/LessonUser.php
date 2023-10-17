<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    public $table = 'lesson_user';

    public $timestamps = false;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'lesson_id', 'watched'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'lesson_id' => 'integer',
        'watched' => 'integer',
    ];

}
