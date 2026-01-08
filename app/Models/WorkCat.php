<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCat extends Model
{
    use HasFactory;

    protected $table = 'WorkCat';
    protected $guarded = [];
    public $timestamps = false;
}
