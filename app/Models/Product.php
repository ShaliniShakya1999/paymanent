<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_class',
        'section',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeActivated($query)
    {
        return $query->where('section', 'activated');
    }

    public function scopeAvailable($query)
    {
        return $query->where('section', 'available');
    }

    public function userProducts()
    {
        return $this->hasMany(UserProduct::class);
    }
}
