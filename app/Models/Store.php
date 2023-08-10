<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    public function setImageAttribute($value){
      
      if(is_string($value)){
        return $this->attributes['image'] = $value;
      }
      
      $name = '/storage/stores/'.date('dmYhms').'.'.$value->getClientOriginalExtension();
      $this->attributes['image'] = $name;
      \Storage::disk('local')->put($name, \File::get($value));
    }

    public function tags(){
      return $this->belongsToMany('App\Models\Tag','store_tags')
        ->using('App\Models\StoreTag');
    }

    public function user(){
      return $this->belongsToMany('App\Models\User','user_stores')
        ->using('App\Models\UserStore');
    }
}
