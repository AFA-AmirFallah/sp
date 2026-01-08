<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreditIndex extends Model
{
    use HasFactory;

    protected $table = 'UserCreditIndex';
    protected $guarded = [];
    public $timestamps =false;
}
