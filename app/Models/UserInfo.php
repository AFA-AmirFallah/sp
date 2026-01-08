<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserInfo extends Authenticatable
{
    protected $table ='UserInfo';
    protected $primaryKey = 'UserName';
    protected $keyType = 'string';
    const CREATED_AT = 'CreateDate';
    protected $guarded =[];
}
