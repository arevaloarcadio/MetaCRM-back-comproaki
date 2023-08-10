<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreTag extends Pivot
{
    use HasFactory;

    protected $table = 'store_tags';
}
