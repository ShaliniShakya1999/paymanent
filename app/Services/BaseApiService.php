<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Base for third-party API integrations: common headers, timeout, retry, logging.
 * Extend this and set $configKey (e.g. 'recharge', 'bill_payment') in child.
 */
abstract class BaseApiService
{
    protected string $configKey = '';
    protected string $module = '';

    protected function baseUrl(): string
    {
        return rtrim(config($this->configKey . '.base_url', ''), '/');
    }

    protected function timeout(): int
    {
        return (int) config($this->configKey . '.timeout', 30);
    }

    protected function verifySsl(): bool
    {
        return (bool) config($this->configKey . '.verify_ssl', true);
    }

    protected function isEnabled(): bool
    {
        return (bool) config($this->configKey . '.enabled', true);
    }

    /**
     * Default headers for PaySprint-style APIs (Authorisedkey, Token).
     */
    protected function defaultHeaders(array $extra = []): array
    {
        return array_merge([
            'Authorisedkey' => config($this->configKey . '.authorisedkey', ''),
            'Token'         => config($this->configKey . '.token', ''),
            'accept'       => 'application/json',
            'content-type' => 'application/json',
        ], $extra);
    }

    /**
     * POST request with optional logging and retry (for idempotent calls).
     */
    protected function post(string $path, array $body = [], ?string $referenceId = null, bool $retry = false): array
    {
        $url = $this->baseUrl() . $path;
        $start = microtime(true);
        $attempt = 0;
        $maxAttempts = $retry ? 3 : 1;

        while ($attempt < $maxAttempts) {
            try {
                $response = Http::timeout($this->timeout())
                    ->withHeaders($this->defaultHeaders())
                    ->when(!$this->verifySsl(), fn ($r) => $r->withoutVerifying())
                    ->post($url, $body);

                $durationMs = (microtime(true) - $start) * 1000;
                $responseBody = $response->json() ?? [];

                ApiRequestLogService::log(
                    $this->module,
                    $url,
                    'POST',
                    $this->defaultHeaders(),
                    $body,
                    $response->status(),
                    $responseBody,
                    $referenceId,
                    null,
                    $durationMs
                );

                return [
                    'success' => $response->successful(),
                    'status_code' => $response->status(),
                    'body' => $responseBody,
                ];
            } catch (Exception $e) {
                $durationMs = (microtime(true) - $start) * 1000;
                Log::error($this->module . ' API exception', ['url' => $url, 'error' => $e->getMessage()]);
                ApiRequestLogService::log(
                    $this->module,
                    $url,
                    'POST',
                    $this->defaultHeaders(),
                    $body,
                    null,
                    null,
                    $referenceId,
                    $e->getMessage(),
                    $durationMs
                );
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    return ['success' => false, 'status_code' => 0, 'body' => [], 'message' => $e->getMessage()];
                }
                sleep(1);
            }
        }

        return ['success' => false, 'status_code' => 0, 'body' => []];
    }

    /**
     * Normalise success/status from partner response.
     */
    protected function normaliseStatus($body, string $keyStatus = 'status'): string
    {
        $status = $body[$keyStatus] ?? $body['data'][$keyStatus] ?? 'pending';
        $status = strtolower((string) $status);
        if (in_array($status, ['success', 'successful'], true)) return 'success';
        if (in_array($status, ['failed', 'failure'], true)) return 'failed';
        return $status;
    }
}
