<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class RechargeApiService
{
    protected string $baseUrl;
    protected string $authorisedKey;
    protected string $token;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl       = config('recharge.base_url');
        $this->authorisedKey = config('recharge.authorisedkey');
        $this->token         = config('recharge.token');
        $this->timeout       = config('recharge.timeout', 30);
        $this->verifySsl     = (bool) config('recharge.verify_ssl', true);
    }

    public function getOperators(): array
    {
        if (!config('recharge.enabled')) {
            return ['success' => false, 'message' => __('Recharge API is disabled.')];
        }
        $url = $this->baseUrl . config('recharge.paths.get_operator');
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorisedkey' => $this->authorisedKey,
                    'Token'         => $this->token,
                    'accept'        => 'application/json',
                ])
                ->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())
                ->post($url);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                $list = $body['data'] ?? $body['operators'] ?? $body['list'] ?? $body['operatorList'] ?? null;
                if (is_array($list)) return ['success' => true, 'data' => $list];
                if (is_array($body) && isset($body[0])) return ['success' => true, 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to fetch operators.');
            Log::warning('Recharge getOperator failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('Recharge getOperator exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function doRecharge(string $operatorId, string $mobileNumber, $amount, string $referenceId): array
    {
        if (!config('recharge.enabled')) {
            return ['success' => false, 'message' => __('Recharge API is disabled.')];
        }
        $url = $this->baseUrl . config('recharge.paths.do_recharge');
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorisedkey' => $this->authorisedKey,
                    'Token'         => $this->token,
                    'content-type'  => 'application/json',
                ])
                ->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())
                ->post($url, [
                    'operator'    => $operatorId,
                    'canumber'    => $mobileNumber,
                    'amount'      => (float) $amount,
                    'referenceid' => $referenceId,
                ]);
            $body = $response->json();
            if ($response->successful()) {
                $status = $body['status'] ?? $body['data']['status'] ?? 'pending';
                return ['success' => true, 'status' => strtolower((string) $status), 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Recharge request failed.');
            Log::warning('Recharge doRecharge failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('Recharge doRecharge exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getStatus(string $referenceId): array
    {
        if (!config('recharge.enabled')) {
            return ['success' => false, 'message' => __('Recharge API is disabled.')];
        }
        $url = $this->baseUrl . config('recharge.paths.status');
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorisedkey' => $this->authorisedKey,
                    'Token'         => $this->token,
                    'content-type'  => 'application/json',
                ])
                ->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())
                ->post($url, ['referenceid' => $referenceId]);
            $body = $response->json();
            if ($response->successful()) {
                $status = $body['status'] ?? $body['data']['status'] ?? 'pending';
                return ['success' => true, 'status' => strtolower((string) $status), 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to fetch status.');
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('Recharge getStatus exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
