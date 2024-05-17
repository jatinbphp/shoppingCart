<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockHistory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_id_value_1', 'option_id_value_2', 'qty'];
}
