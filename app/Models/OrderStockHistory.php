<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStockHistory extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','type','product_id','option_id_value_1','option_id_value_2','qty'];
}
