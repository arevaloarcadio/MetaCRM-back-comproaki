<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{   
    use HasFactory;

    public function setImageAttribute($value){
        
        if(is_string($value)){
            return $this->attributes['image'] = $value;
        }

        $name = '/storage/products/'.date('dmYhms').'.'.$value->getClientOriginalExtension();
        $this->attributes['image'] = $name;
        \Storage::disk('local')->put($name, \File::get($value));
    }

    public function store(){
        return $this->belongsTo('App\Models\Store','store_id');
    }
}
