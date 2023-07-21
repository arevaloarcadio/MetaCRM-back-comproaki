<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $guarded = [];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function parent(){
    	return $this->belongsTo('App\Models\User','parent_id');
    }

    public function host(){
    	return $this->belongsTo('App\Models\Host');
    }
}
