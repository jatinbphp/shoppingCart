<?php

namespace App\Models;
use App\Models\UserAddresses;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $appends = ['full_name'];

    protected $fillable = ['categories_id', 'name', 'email', 'password', 'role', 'image', 'phone', 'status'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function user_addresses(){
        return $this->hasMany(UserAddresses::class, 'user_id')->orderBy('id', 'ASC');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function orderItems(){
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }

    public function getFullNameAttribute(){
        return $this->name . ' (' . $this->email . ')';
    }
}
