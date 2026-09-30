<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RechargeTransaction extends Model
{
    protected $table = 'recharge_transactions';

    protected $fillable = [
        'user_id',
        'reference_id',
        'operator_id',
        'operator_name',
        'mobile_number',
        'amount',
        'api_response',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'api_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
