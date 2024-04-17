<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'order_product_id', 'product_option_id', 'product_option_value_id', 'name', 'value', 'price'];
}