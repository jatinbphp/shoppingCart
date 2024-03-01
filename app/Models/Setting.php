<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address',
        'phone_number',
        'email_address',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url',
        'linkedin_url',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
