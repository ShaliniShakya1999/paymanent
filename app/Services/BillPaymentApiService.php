<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillPaymentApiService
{
    protected string $baseUrl;
    protected string $authorisedKey;
    protected string $token;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('bill_payment.base_url'), '/');
        $this->authorisedKey = config('bill_payment.authorised_key', '');
        $this->token = config('bill_payment.token', '');
        $this->timeout = (int) config('bill_payment.timeout', 30);
        $this->verifySsl = (bool) config('bill_payment.verify_ssl', false);
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type'   => 'application/json',
            'Accept'        => 'application/json',
            'Authorisedkey' => $this->authorisedKey,
            'Token'         => $this->token,
        ];
    }

    protected function post(string $endpoint, array $body = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $response = Http::timeout($this->timeout)
            ->withOptions(['verify' => $this->verifySsl])
            ->withHeaders($this->getHeaders())
            ->post($url, $body);

        $data = $response->json();
        if ($response->failed()) {
            Log::warning('BillPayment API request failed', ['url' => $url, 'status' => $response->status(), 'body' => $data]);
        }
        return is_array($data) ? $data : [];
    }

    /**
     * Get operators (bill-payment getoperator API).
     * Endpoint: POST /api/v1/service/bill-payment/bill/getoperator
     * Body: { "mode": "online/offline" }
     * Response: response_code 1, status true, data = array of { id, name, category, viewbill, regex, displayname, ... }
     *
     * @param string $mode e.g. "online/offline", "prepaid", "electricity", etc.
     * @return array
     */
    public function getOperators(string $mode = ''): array
    {
        $body = $mode !== '' ? ['mode' => $mode] : ['mode' => 'online/offline'];
        $result = $this->post('/api/v1/service/bill-payment/bill/getoperator', $body);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        $success = ($code === 1) || !empty($result['status']);
        if (!$success) {
            return [
                'response_code' => $code,
                'operators'     => [],
                'message'       => $result['message'] ?? 'Failed to fetch operators',
            ];
        }
        $data = $result['data'] ?? [];
        $operators = isset($data['operators']) ? $data['operators'] : (is_array($data) && array_values($data) === $data ? $data : []);
        return [
            'response_code' => 1,
            'operators'     => $operators,
            'message'       => $result['message'] ?? 'Operator List Fetched',
        ];
    }

    /**
     * Fetch bill details (fetchbill API).
     * Endpoint: POST /api/v1/service/bill-payment/bill/fetchbill
     * Body: { "operator": 11, "canumber": 102277100, "mode": "online", "ad1": "optional" }
     * Response: response_code 1, status true, amount, name, duedate, bill_fetch { amount, name, duedate, ad2, ad3 }, message
     *
     * @param string $operatorId Operator id (sent as numeric to API when numeric)
     * @param string $canumber Consumer/account number
     * @param string $mode e.g. "online", "offline"
     * @param array $extra Optional ad1, ad2, ad3 per operator
     * @return array
     */
    public function fetchBill(string $operatorId, string $canumber, string $mode = '', array $extra = []): array
    {
        $operator = ctype_digit((string) $operatorId) ? (int) $operatorId : $operatorId;
        $body = array_merge([
            'operator' => $operator,
            'canumber'  => $canumber,
            'mode'      => $mode ?: 'online',
        ], $extra);
        $result = $this->post('/api/v1/service/bill-payment/bill/fetchbill', $body);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        $success = ($code === 1) || !empty($result['status']);
        if (!$success) {
            $msg = $result['message'] ?? 'Failed to fetch bill';
            if ($code === 18) {
                $msg = __('Duplicate transaction. This request has already been processed.');
            }
            return ['response_code' => $code, 'message' => $msg, 'bill_fetch' => null, 'amount' => null];
        }
        $billFetch = $result['bill_fetch'] ?? $result['data']['bill_fetch'] ?? null;
        $amount = $result['amount'] ?? $result['data']['amount'] ?? null;
        return [
            'response_code' => 1,
            'message'       => $result['message'] ?? 'Bill Fetched Success.',
            'bill_fetch'    => $billFetch,
            'amount'        => $amount,
            'data'          => array_merge($result, ['name' => $result['name'] ?? null, 'duedate' => $result['duedate'] ?? null]),
        ];
    }

    /**
     * Pay bill (paybill API).
     * Endpoint: POST /api/v1/service/bill-payment/bill/paybill
     * Body: operator, canumber, amount, referenceid, latitude, longitude, mode, bill_fetch (object)
     * Response: status, response_code (1 success, 18 duplicate), message
     *
     * @param array $payload operator, canumber, amount, referenceid, mode, bill_fetch [, latitude, longitude ]
     * @return array
     */
    public function payBill(array $payload): array
    {
        $billFetch = $payload['bill_fetch'] ?? [];
        if (is_string($billFetch)) {
            $decoded = json_decode($billFetch, true);
            $billFetch = is_array($decoded) ? $decoded : [];
        }
        if (is_array($billFetch)) {
            if (isset($billFetch['amount']) && !isset($billFetch['billAmount'])) {
                $billFetch['billAmount'] = (string) $billFetch['amount'];
                $billFetch['billnetamount'] = (string) $billFetch['amount'];
            }
            if (isset($billFetch['duedate']) && !isset($billFetch['dueDate'])) {
                $billFetch['dueDate'] = $billFetch['duedate'];
            }
            if (isset($billFetch['name']) && !isset($billFetch['userName'])) {
                $billFetch['userName'] = $billFetch['name'];
            }
        }
        $body = [
            'operator'    => $payload['operator'] ?? '',
            'canumber'    => $payload['canumber'] ?? '',
            'amount'      => (string) ($payload['amount'] ?? '0'),
            'referenceid' => $payload['referenceid'] ?? '',
            'mode'        => !empty($payload['mode']) ? $payload['mode'] : 'online',
            'bill_fetch'  => $billFetch,
        ];
        if (isset($payload['latitude']) && $payload['latitude'] !== '') {
            $body['latitude'] = (string) $payload['latitude'];
        }
        if (isset($payload['longitude']) && $payload['longitude'] !== '') {
            $body['longitude'] = (string) $payload['longitude'];
        }
        $result = $this->post('/api/v1/service/bill-payment/bill/paybill', $body);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        if ($code === 18) {
            return [
                'response_code' => 18,
                'status'        => $result['status'] ?? false,
                'message'       => $result['message'] ?? __('Duplicate Transaction'),
                'data'          => $result['data'] ?? $result,
            ];
        }
        return $result;
    }

    /**
     * Get bill payment status.
     * Endpoint: POST /api/v1/service/bill-payment/bill/status
     * Body: { "referenceid": "1234567890" }
     * Response: response_code 1, status true, data { txnid, operatorname, canumber, amount, status, refid, ... }, message
     *
     * @param string $referenceId
     * @return array
     */
    public function getStatus(string $referenceId): array
    {
        $result = $this->post('/api/v1/service/bill-payment/bill/status', ['referenceid' => $referenceId]);
        return $result;
    }
}
