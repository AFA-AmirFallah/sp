<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethodMeta extends Model
{
    use HasFactory;

    protected $table = 'PayMethodMeta';
    protected $guarded = [];
}
