<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmClassRoom extends Model
{
    //
    public function buildings() {
        return $this->belongsTo('App\SmBuilding', 'building_id', 'id');
    }
}
