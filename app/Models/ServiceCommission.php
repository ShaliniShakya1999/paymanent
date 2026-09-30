<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCommission extends Model
{
    protected $fillable = [
        'service_slug',
        'service_name',
        'commission_percent',
        'commission_fixed',
        'is_active',
    ];

    protected $casts = [
        'commission_percent' => 'decimal:2',
        'commission_fixed' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get commission for a service by slug.
     */
    public static function getBySlug(string $slug): ?self
    {
        return static::where('service_slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Calculate admin commission amount for given transaction amount.
     */
    public function calculateCommission(float $amount): float
    {
        $percent = (float) $this->commission_percent;
        $fixed = (float) $this->commission_fixed;
        return round(($amount * $percent / 100) + $fixed, 2);
    }
}
