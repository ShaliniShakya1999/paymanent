<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class BillPaymentApiService
{
    protected string $baseUrl;
    protected string $authorisedKey;
    protected string $token;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = config('bill_payment.base_url');
        $this->authorisedKey = config('bill_payment.authorisedkey');
        $this->token = config('bill_payment.token');
        $this->timeout = config('bill_payment.timeout', 30);
        $this->verifySsl = (bool) config('bill_payment.verify_ssl', true);
    }

    protected function headers(): array
    {
        return ['Authorisedkey' => $this->authorisedKey, 'Token' => $this->token, 'accept' => 'application/json', 'content-type' => 'application/json'];
    }

    public function getOperators(string $mode = 'online'): array
    {
        if (!config('bill_payment.enabled')) return ['success' => false, 'message' => __('Bill Payment API is disabled.')];
        $url = $this->baseUrl . config('bill_payment.paths.get_operator');
        try {
            $response = Http::timeout($this->timeout)->withHeaders($this->headers())->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())->post($url, ['mode' => $mode]);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                $list = $body['data'] ?? $body['operators'] ?? $body['list'] ?? $body['operatorList'] ?? null;
                if (is_array($list)) return ['success' => true, 'data' => $list];
                if (is_array($body) && isset($body[0])) return ['success' => true, 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to fetch operators.');
            Log::warning('BillPayment getOperator failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('BillPayment getOperator exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function fetchBill($operator, string $canumber, string $mode = 'online', array $extra = []): array
    {
        if (!config('bill_payment.enabled')) return ['success' => false, 'message' => __('Bill Payment API is disabled.')];
        $url = $this->baseUrl . config('bill_payment.paths.fetch_bill');
        $payload = array_merge(['operator' => (string) $operator, 'canumber' => $canumber, 'mode' => $mode], $extra);
        try {
            $response = Http::timeout($this->timeout)->withHeaders($this->headers())->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())->post($url, $payload);
            $body = $response->json() ?? [];
            if ($response->successful()) return ['success' => true, 'data' => $body];
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to fetch bill.');
            Log::warning('BillPayment fetchBill failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('BillPayment fetchBill exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function payBill(array $payload): array
    {
        if (!config('bill_payment.enabled')) return ['success' => false, 'message' => __('Bill Payment API is disabled.')];
        $url = $this->baseUrl . config('bill_payment.paths.pay_bill');
        try {
            $response = Http::timeout($this->timeout)->withHeaders($this->headers())->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())->post($url, $payload);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                $status = $body['status'] ?? $body['data']['status'] ?? 'pending';
                return ['success' => true, 'status' => strtolower((string) $status), 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Bill payment failed.');
            Log::warning('BillPayment payBill failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('BillPayment payBill exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getStatus(string $referenceId): array
    {
        if (!config('bill_payment.enabled')) return ['success' => false, 'message' => __('Bill Payment API is disabled.')];
        $url = $this->baseUrl . config('bill_payment.paths.status');
        try {
            $response = Http::timeout($this->timeout)->withHeaders($this->headers())->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())->post($url, ['referenceid' => $referenceId]);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                $status = $body['status'] ?? $body['data']['status'] ?? 'pending';
                return ['success' => true, 'status' => strtolower((string) $status), 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to fetch status.');
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('BillPayment getStatus exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
