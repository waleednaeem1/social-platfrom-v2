<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->with('getShallowCourseData');
    }

    // public function course()
    // {
    //     return $this->belongsTo(ShallowCourse::class,'course_id','parent_course_id');
    // }
}
