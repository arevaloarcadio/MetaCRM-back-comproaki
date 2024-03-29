<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     public function setImageAttribute($value){
        
        if(is_string($value)){
            $this->attributes['image'] = $value;
            return;
        }

        $name = '/storage/profiles/'.date('dmYhms').'.'.$value->getClientOriginalExtension();
        $this->attributes['image'] = $name;
        \Storage::disk('local')->put($name, \File::get($value));
    }

    public function organizations(){
        return $this->hasMany('App\Models\Organization','user_id');
    }

    public function likeStores(){
      return $this->belongsToMany('App\Models\Store','followers')
        ->using('App\Models\Follower');
    }

    public function stores(){
      return $this->belongsToMany('App\Models\Store','user_stores')
        ->using('App\Models\UserStore');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
