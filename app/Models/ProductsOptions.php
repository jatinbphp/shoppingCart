<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsOptions extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_id', 'required'];
}
