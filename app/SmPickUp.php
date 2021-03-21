<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmPickUp extends Model
{
	protected $table = "sm_pickups";

    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }

}
