<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmStaffID extends Model
{
    public function gender(){
        return $this->belongsTo('App\SmBaseSetup', 'gender_id', 'id');
    }

}
