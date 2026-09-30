<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    protected $table = 'verification_logs';

    protected $fillable = [
        'user_id',
        'type',
        'identifier_masked',
        'request_ref',
        'success',
        'api_response_summary',
    ];

    protected $casts = [
        'success'              => 'boolean',
        'api_response_summary' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
