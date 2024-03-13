<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'product_id', 'full_name', 'email_address', 'rating', 'description'];
}
