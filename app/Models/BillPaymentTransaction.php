<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillPaymentTransaction extends Model
{
    protected $table = 'bill_payment_transactions';

    protected $fillable = [
        'user_id', 'operator_id', 'operator_name', 'canumber', 'amount', 'reference_id',
        'status', 'mode', 'bill_fetch', 'api_request', 'api_response', 'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'bill_fetch' => 'array',
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
