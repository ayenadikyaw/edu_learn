<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;
    protected $fillable = ['title', 'content', 'course_id'];

    //relationship
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
