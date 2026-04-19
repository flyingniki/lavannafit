<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = ['name', 'price', 'period', 'description', 'features', 'sort_order', 'is_active'];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
    ];
}
