<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AepsApiService
{
    protected string $baseUrl;
    protected string $token;
    protected string $apiKey;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('aeps.base_url', ''), '/');
        $this->token = config('aeps.token', '');
        $this->apiKey = config('aeps.api_key', '');
        $this->timeout = (int) config('aeps.timeout', 30);
        $this->verifySsl = (bool) config('aeps.verify_ssl', false);
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
            'X-Api-Key' => $this->apiKey,
        ];
    }

    protected function post(string $endpoint, array $body = []): array
    {
        if (!$this->baseUrl) {
            return ['success' => false, 'message' => __('AEPS API is not configured.'), 'response_code' => 0];
        }
        $url = $this->baseUrl . $endpoint;
        $response = Http::timeout($this->timeout)
            ->withOptions(['verify' => $this->verifySsl])
            ->withHeaders($this->getHeaders())
            ->post($url, $body);
        $data = $response->json();
        if ($response->failed()) {
            Log::warning('AEPS API request failed', ['url' => $url, 'status' => $response->status()]);
        }
        return is_array($data) ? $data : [];
    }

    public function twoFactorAuth(string $type, array $params = []): array
    {
        $result = $this->post('/api/v1/aeps/2fa', array_merge(['type' => $type], $params));
        $code = (int) ($result['response_code'] ?? $result['code'] ?? 0);
        return [
            'success' => ($code === 1 || $code === 200),
            'message' => $result['message'] ?? '',
            'response_code' => $code,
            'data' => $result['data'] ?? $result,
        ];
    }

    public function getBankList(): array
    {
        $result = $this->post('/api/v1/aeps/banks', []);
        $code = (int) ($result['response_code'] ?? $result['code'] ?? 0);
        $banks = $result['data']['banks'] ?? $result['banks'] ?? $result['data'] ?? [];
        return [
            'success' => ($code === 1 || $code === 200),
            'message' => $result['message'] ?? '',
            'response_code' => $code,
            'banks' => $banks,
        ];
    }

    public function register(array $params): array
    {
        $result = $this->post('/api/v1/aeps/register', $params);
        $code = (int) ($result['response_code'] ?? $result['code'] ?? 0);
        return [
            'success' => ($code === 1 || $code === 200),
            'message' => $result['message'] ?? '',
            'response_code' => $code,
            'data' => $result['data'] ?? $result,
        ];
    }

    public function authenticate(array $params): array
    {
        $result = $this->post('/api/v1/aeps/authenticate', $params);
        $code = (int) ($result['response_code'] ?? $result['code'] ?? 0);
        return [
            'success' => ($code === 1 || $code === 200),
            'message' => $result['message'] ?? '',
            'response_code' => $code,
            'data' => $result['data'] ?? $result,
        ];
    }

    public function getStatus(string $referenceId): array
    {
        $result = $this->post('/api/v1/aeps/status', ['reference_id' => $referenceId]);
        return is_array($result) ? $result : [];
    }
}
