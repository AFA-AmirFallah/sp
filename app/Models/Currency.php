<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * currency.status: 0: new list  10 - 19: active   20 - 19: Deactive    
 * 
 * 10:active
 * 
 * 20:Deactive
 * 
 */
class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];
}
