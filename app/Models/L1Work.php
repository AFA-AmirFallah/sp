<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class L1Work extends Model
{
    use HasFactory;

    protected $table = 'L1Work';
    protected $guarded = [];
    public $timestamps = false;
}
