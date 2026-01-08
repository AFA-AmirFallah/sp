<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceMeta extends Model
{
    use HasFactory;


    protected $table = 'DeviceMeta';
    protected $guarded = [];
    public $timestamps = false;
}
