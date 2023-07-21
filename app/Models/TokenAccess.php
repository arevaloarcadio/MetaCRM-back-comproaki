<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenAccess extends Model
{
    public function host(){
    	return $this->belongsTo(Host::class);
    }
}
