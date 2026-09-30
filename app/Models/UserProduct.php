<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'user_products';

    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'requested_at',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActivated($query)
    {
        return $query->where('status', 'activated');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
