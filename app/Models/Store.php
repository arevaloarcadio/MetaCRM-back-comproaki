<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function setImageAttribute($value){
        $name = '/storage/stores/'.date('dmYhms').'.'.$value->getClientOriginalExtension();
        $this->attributes['image'] = $name;
        \Storage::disk('local')->put($name, \File::get($value));
    }
}
