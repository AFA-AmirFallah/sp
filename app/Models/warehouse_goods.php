<?php

namespace App\Models;

use App\Http\Controllers\woocommerce\product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warehouse_goods extends Model
{
    use HasFactory;
    protected $table = 'warehouse_goods';
    protected $guarded =[];
}
