<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredit_shafatel extends Model
{
    use HasFactory;
    protected $connection = 'ShafatelDB';
    protected $table = 'UserCredit';
    public $timestamps = false;
    protected $guarded = [];
}
