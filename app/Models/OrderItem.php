<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes ;

    protected $foreignKey = 'product_id';

    protected $fillable = ['order_id', 'product_id', 'product_name', 'product_sku', 'product_price','product_qty', 'sub_total'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
