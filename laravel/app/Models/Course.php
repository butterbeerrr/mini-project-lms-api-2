<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['instructor_id', 'category_id', 'title', 'description','rating', 'thumbnail', 'level', 'duration', 'status', 'enrolled_count'];

    public function category(){
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function instructor(){
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
