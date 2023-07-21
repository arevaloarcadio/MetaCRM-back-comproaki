<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function setImageAttribute($value){
        $name = '/storage/products/'.date('dmYhms').'.'.$value->getClientOriginalExtension();
        $this->attributes['image'] = $name;
        \Storage::disk('local')->put($name, \File::get($value));
    }

    public function store(){
        return $this->belongsTo('App\Models\Store','store_id');
    }
}
