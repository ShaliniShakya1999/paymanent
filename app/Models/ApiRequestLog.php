<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRequestLog extends Model
{
    protected $table = 'api_request_logs';

    protected $fillable = [
        'user_id',
        'module',
        'action',
        'reference_id',
        'request_url',
        'request_headers_masked',
        'request_body_masked',
        'response_status',
        'response_body_summary',
    ];

    protected $casts = [
        'request_headers_masked' => 'array',
        'request_body_masked'    => 'array',
        'response_body_summary'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
