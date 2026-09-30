<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RechargeTransaction extends Model
{
    protected $table = 'recharge_transactions';

    protected $fillable = [
        'user_id', 'operator_id', 'operator_name', 'mobile', 'amount',
        'reference_id', 'status', 'api_request', 'api_response', 'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'api_request' => 'array',
        'api_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
