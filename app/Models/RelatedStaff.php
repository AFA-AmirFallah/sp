<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedStaff extends Model
{
    use HasFactory;

    protected $table = 'RelatedStaff';
    public $timestamps = false;
    protected $guarded = [];

}
