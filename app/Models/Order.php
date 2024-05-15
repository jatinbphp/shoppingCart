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

    const STATUS_TYPE_PENDING  = 'pending';
    const STATUS_TYPE_REJECT   = 'reject';
    const STATUS_TYPE_COMPLETE = 'complete';
    const STATUS_TYPE_CANCEL   = 'cancel';
    public static $allStatus = [
        self::STATUS_TYPE_PENDING => 'Pending',
        self::STATUS_TYPE_REJECT => 'Reject',
        self::STATUS_TYPE_COMPLETE => 'Complete',
        self::STATUS_TYPE_CANCEL => 'Cancel',
    ];
    
    const DELIVERY_METHOD_FEDEX = '3-5 WORKING DAYS';
    public static $allDeliveryMethod = [
        self::DELIVERY_METHOD_FEDEX => '3-5 WORKING DAYS',
    ];
}
