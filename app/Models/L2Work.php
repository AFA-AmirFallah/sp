<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class L2Work extends Model
{
    use HasFactory;

    protected $table = 'L2Work';
    protected $guarded = [];
    public $timestamps = false;
}
