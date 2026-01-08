<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParvandehMain extends Model
{
    use HasFactory;
    protected $table = 'ParvandehMain';
    protected $primaryKey = 'ParvandehID';
    public $timestamps = false;
    protected $guarded = [];
}
