<?php

namespace App\Services;

use App\Models\ApiRequestLog;
use Illuminate\Support\Facades\Auth;

class ApiRequestLogService
{
    public static function log(
        string $module,
        ?string $endpoint,
        string $method = 'POST',
        array $requestHeaders = [],
        array $requestBody = [],
        ?int $responseStatus = null,
        ?array $responseBody = null,
        ?string $referenceId = null,
        ?string $errorMessage = null,
        ?float $durationMs = null
    ): void {
        if (!config('logging.api_request_log_enabled', true)) {
            return;
        }
        ApiRequestLog::create([
            'module' => $module,
            'endpoint' => $endpoint,
            'method' => $method,
            'user_id' => Auth::id(),
            'reference_id' => $referenceId,
            'response_status' => $responseStatus,
            'request_headers_masked' => ApiRequestLog::maskSensitive($requestHeaders),
            'request_body_masked' => ApiRequestLog::maskSensitive($requestBody),
            'response_body' => $responseBody,
            'error_message' => $errorMessage,
            'duration_ms' => $durationMs,
        ]);
    }
}
