<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description', 'profile_image', 'price', 'level_id', 'category_id', 'duration', 'user_id', 'status', 'short_description', 'learning_points'];
    protected $casts = [
        'learning_points' => 'array',
    ];  

    //relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relationship
    public function lessons()
    {
        return $this->hasMany(Lesson::class,'course_id');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class,'category_id');
    }

    public function courseLevel()
    {
        return $this->belongsTo(CourseLevel::class,'level_id');
    }

    //relationship
    public function enrolledStudents()
    {
        return $this->belongsToMany(User::class, 'student_enrolled')
            ->withPivot('is_completed', 'completed_at')
            ->withTimestamps();
    }
}
