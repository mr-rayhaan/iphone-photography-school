<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    // Badge.php
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
