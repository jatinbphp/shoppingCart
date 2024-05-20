<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','address_id', 'total_amount', 'status', 'delivey_method', 'notes', 'address_info'];

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function address(){
        return $this->belongsTo(UserAddresses::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function orderOptions(){
        return $this->hasMany(OrderOption::class);
    }

    const STATUS_TYPE_PENDING  = 'pending';
    const STATUS_TYPE_SHIPPED   = 'shipped';
    const STATUS_TYPE_COMPLETE = 'completed';
    const STATUS_TYPE_CANCEL   = 'cancelled';
    public static $allStatus = [
        self::STATUS_TYPE_PENDING => 'Pending',
        self::STATUS_TYPE_SHIPPED => 'Shipped',
        self::STATUS_TYPE_COMPLETE => 'Completed',
        self::STATUS_TYPE_CANCEL => 'Cancelled',
    ];

    const DELIVERY_METHOD_FEDEX = 'Next Day Delivery (order before 12pm)';
    public static $allDeliveryMethod = [
        self::DELIVERY_METHOD_FEDEX => 'Next Day Delivery (order before 12pm)',
    ];
}
