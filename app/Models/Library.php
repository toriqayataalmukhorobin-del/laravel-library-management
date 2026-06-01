<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'description',
        'image',
        'opening_hours',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
