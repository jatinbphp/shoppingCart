<?php

namespace App\Models;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['full_name'];

    protected $fillable = ['user_id', 'category_id', 'sku', 'product_name', 'description', 'status', 'price', 'type'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    /* product type */
    const TYPE_SALE = 'sale';
    const TYPE_NEW = 'new';
    const TYPE_HOT = 'hot';
    public static $type = [
        self::TYPE_SALE => 'Sale',
        self::TYPE_NEW  => 'New',
        self::TYPE_HOT  => 'Hot',
    ];


    public function product_images()
    {
        return $this->hasMany(ProductImages::class, 'product_id')->orderBy('id', 'DESC');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function options()
    {
        return $this->hasMany(ProductsOptions::class, 'product_id')->orderBy('option_name', 'ASC');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id')->orderBy('option_value', 'ASC');
    }

    public function getFullNameAttribute()
    {
        return $this->product_name . ' (' . $this->sku . ')';
    }

    public function product_image()
    {
        return $this->hasOne(ProductImages::class, 'product_id')->orderBy('id', 'DESC')->latest();
    }

    public function products_options_value(){
        return $this->hasOne(ProductsOptionsValues::class, 'product_id');
    }
}