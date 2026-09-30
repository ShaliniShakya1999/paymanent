<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AepsTransaction extends Model
{
    protected $table = 'aeps_transactions';

    protected $fillable = [
        'user_id',
        'reference_id',
        'bank_id',
        'bank_name',
        'aadhaar_masked',
        'amount',
        'api_response',
        'status',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'api_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
