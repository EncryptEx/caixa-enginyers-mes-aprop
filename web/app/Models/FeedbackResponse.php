<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackResponse extends Model
{

    protected $fillable = [
        'municipi',
        'rating',
        'time_increment',
        'timetable'
    ];

    use HasFactory;
}
