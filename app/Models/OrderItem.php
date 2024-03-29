<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $foreignKey = 'product_id';

    protected $fillable = ['order_id', 'product_id', 'product_name', 'product_sku', 'product_price','product_qty', 'sub_total'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function orderOptions(){
        return $this->hasMany(OrderOption::class, 'order_product_id');
    }
}