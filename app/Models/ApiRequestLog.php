<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiRequestLog extends Model
{
    protected $table = 'api_request_logs';

    protected $fillable = [
        'module', 'endpoint', 'method', 'user_id', 'reference_id',
        'response_status', 'request_headers_masked', 'request_body_masked',
        'response_body', 'error_message', 'duration_ms',
    ];

    protected $casts = [
        'request_headers_masked' => 'array',
        'request_body_masked' => 'array',
        'response_body' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function maskSensitive(array $data, array $keys = []): array
    {
        $defaultKeys = ['aadhaar', 'pan', 'otp', 'token', 'password'];
        $keys = array_merge($defaultKeys, $keys);
        foreach ($data as $k => $v) {
            $lower = strtolower((string) $k);
            foreach ($keys as $key) {
                if (str_contains($lower, $key) && is_string($v)) {
                    $data[$k] = substr($v, 0, 4) . '****';
                    break;
                }
            }
            if (is_array($v)) {
                $data[$k] = self::maskSensitive($v, $keys);
            }
        }
        return $data;
    }
}
