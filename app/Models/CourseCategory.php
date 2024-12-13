<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\CourseCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'course_categories';

    //relationship
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
