<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_id_value_1', 'option_id_value_2', 'total_qty', 'order_qty', 'remaining_qty'];
}
