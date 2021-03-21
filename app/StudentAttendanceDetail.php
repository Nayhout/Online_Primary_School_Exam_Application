<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendanceDetail extends Model
{
    protected $table = "sm_student_attendances";
    public function studentInfo()
    {
        return $this->belongsTo('App\SmStudent', 'student_id', 'id');
    }
}
