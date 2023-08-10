<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserStore extends Pivot
{   
    use HasFactory;
    
    protected $table = 'user_stores';
}
