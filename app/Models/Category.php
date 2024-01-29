<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'image', 'status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public static function getActiveCategories()
    {
        return Category::where('status', 'active')->pluck('name', 'id')->prepend('Please Select', '');
    }
}
