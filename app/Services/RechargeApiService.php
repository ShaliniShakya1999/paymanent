<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RechargeApiService
{
    protected string $baseUrl;
    protected string $authorisedKey;
    protected string $token;
    protected string $partnerId;
    protected string $jwtSecret;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('recharge.base_url'), '/');
        $this->authorisedKey = config('recharge.authorised_key', '');
        $this->token = config('recharge.token', '');
        $this->partnerId = config('recharge.partner_id', '');
        $this->jwtSecret = config('recharge.jwt_secret', '');
        $this->timeout = (int) config('recharge.timeout', 30);
        $this->verifySsl = (bool) config('recharge.verify_ssl', false);
    }

    protected function buildToken(?string $reqid = null): string
    {
        if ($this->token !== '' && substr_count($this->token, '.') === 2) {
            return $this->token;
        }

        $partnerId = $this->partnerId;
        $secret = $this->jwtSecret;

        if (($partnerId === '' || $secret === '') && $this->token !== '') {
            $decoded = base64_decode($this->token, true);
            if ($decoded !== false && $decoded !== '') {
                if ($partnerId === '' && preg_match('/^[A-Z0-9]+/', $decoded, $matches)) {
                    $partnerId = $matches[0] ?? '';
                }
                if ($secret === '' && $partnerId !== '' && strpos($decoded, $partnerId) === 0) {
                    $secret = substr($decoded, strlen($partnerId));
                }
                if ($secret === '') {
                    $secret = $decoded;
                }
            }
        }

        if ($partnerId === '' || $secret === '') {
            return $this->token;
        }

        $reqid = $reqid ?: (string) rand(100000, 999999);
        $payload = [
            'timestamp' => time(),
            'partnerId' => $partnerId,
            'reqid' => $reqid,
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    protected function getHeaders(?string $reqid = null): array
    {
        return [
            'Content-Type'   => 'application/json',
            'Authorisedkey'  => $this->authorisedKey,
            'Accept'         => 'application/json',
            'Token'          => $this->buildToken($reqid),
        ];
    }

    protected function post(string $endpoint, array $body = [], ?string $reqid = null): array
    {
        $url = $this->baseUrl . $endpoint;
        $response = Http::timeout($this->timeout)
            ->withOptions(['verify' => $this->verifySsl])
            ->withHeaders($this->getHeaders($reqid))
            ->post($url, $body);

        $data = $response->json();
        if ($response->failed()) {
            Log::warning('Recharge API request failed', ['url' => $url, 'status' => $response->status(), 'body' => $data]);
        }
        return is_array($data) ? $data : [];
    }

    /**
     * Get operators (PaySprint recharge getoperator).
     *
     * @return array
     */
    public function getOperators(): array
    {
        $result = $this->post('/api/v1/service/recharge/recharge/getoperator', []);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        if ($code !== 1) {
            return [
                'response_code' => $code,
                'operators'     => [],
                'message'       => $result['message'] ?? 'Failed to fetch operators',
            ];
        }
        $operators = $result['data']['operators'] ?? $result['operators'] ?? $result['data'] ?? [];
        $operators = $this->normalizeOperators($operators);
        return ['response_code' => 1, 'operators' => $operators, 'message' => $result['message'] ?? 'Success'];
    }

    protected function normalizeOperators($operators): array
    {
        if (!is_array($operators)) {
            return [];
        }

        $normalized = [];
        foreach ($operators as $operator) {
            if (!is_array($operator)) {
                continue;
            }

            $rawId = $operator['operator_id']
                ?? $operator['id']
                ?? $operator['operatorId']
                ?? $operator['opid']
                ?? $operator['opcode']
                ?? $operator['operator_code']
                ?? null;

            $operatorId = preg_replace('/\D+/', '', (string) $rawId);
            if ($operatorId === '') {
                continue;
            }

            $operatorName = $operator['operator_name']
                ?? $operator['name']
                ?? $operator['operatorName']
                ?? ('Operator ' . $operatorId);

            $normalized[] = array_merge($operator, [
                'operator_id' => $operatorId,
                'operator_name' => $operatorName,
            ]);
        }

        return $normalized;
    }

    /**
     * Do recharge (dorecharge API).
     *
     * @param string $operatorId
     * @param string $mobileNumber
     * @param float $amount
     * @param string $referenceId Unique per request
     * @return array
     */
    public function doRecharge(string $operatorId, string $mobileNumber, float $amount, string $referenceId): array
    {
        $operatorId = preg_replace('/\D+/', '', $operatorId);

        $body = [
            'operator'     => $operatorId,
            'canumber'     => $mobileNumber,
            'amount'       => $amount,
            'referenceid'  => $referenceId,
        ];
        $result = $this->post('/api/v1/service/recharge/recharge/dorecharge', $body, $referenceId);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        if ($code === 18) {
            return [
                'response_code' => 18,
                'status'        => false,
                'message'       => __('Duplicate reference id. This reference has already been used.'),
                'data'          => $result['data'] ?? $result,
            ];
        }
        $success = ($code === 1 && (isset($result['status']) ? (bool) $result['status'] : true));
        return [
            'response_code' => $code,
            'status'        => $success,
            'message'       => $result['message'] ?? ($success ? 'Success' : 'Failed'),
            'data'          => $result['data'] ?? $result,
        ];
    }

    /**
     * Get recharge status.
     *
     * @param string $referenceId
     * @return array success|failed|refunded|pending
     */
    public function getStatus(string $referenceId): array
    {
        $result = $this->post('/api/v1/service/recharge/recharge/status', ['referenceid' => $referenceId], $referenceId);
        $status = $result['data']['status'] ?? $result['status'] ?? 'pending';
        if (strtolower((string) $status) === 'refunded') {
            $result['data'] = $result['data'] ?? [];
            $result['data']['status'] = 'refunded';
        }
        return $result;
    }
}
