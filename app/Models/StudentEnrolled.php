<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrolled extends Model
{
    use HasFactory;

    protected $table = 'student_enrolled';

    protected $fillable = ['user_id', 'course_id', 'is_completed', 'completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
