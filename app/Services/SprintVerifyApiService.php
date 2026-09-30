<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SprintVerifyApiService
{
    protected string $baseUrl;
    protected string $authorisedKey;
    protected string $partnerId;
    protected string $jwtSecret;
    protected string $staticToken;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl       = rtrim(config('sprintverify.base_url'), '/');
        $this->authorisedKey  = config('sprintverify.authorised_key', '');
        $this->partnerId     = config('sprintverify.partner_id', 'CORP00001');
        $this->jwtSecret     = config('sprintverify.jwt_secret', '');
        $this->staticToken   = config('sprintverify.static_token', '');
        $this->timeout       = (int) config('sprintverify.timeout', 30);
        $this->verifySsl     = (bool) config('sprintverify.verify_ssl', false);
    }

    /**
     * Build Token for SprintVerify API: use static token if set, else JWT (payload: timestamp, partnerId, reqid).
     */
    public function buildToken(?string $reqid = null): string
    {
        if ($this->staticToken !== '') {
            return $this->staticToken;
        }
        $reqid = $reqid ?: (string) (time() . rand(100000, 999999));
        $payload = [
            'timestamp'  => time(),
            'partnerId'  => $this->partnerId,
            'reqid'      => $reqid,
        ];
        $key = $this->jwtSecret ?: 'default-secret-change-in-env';
        return JWT::encode($payload, $key, 'HS256');
    }

    protected function getHeaders(?string $reqid = null): array
    {
        $headers = [
            'Content-Type'   => 'application/json',
            'Accept'         => 'application/json',
            'Token'          => $this->buildToken($reqid),
            'Authorisedkey'  => $this->authorisedKey,
        ];
        return $headers;
    }

    /**
     * Aadhaar Send OTP: User-Agent is partner_id.
     */
    protected function getHeadersWithUserAgent(?string $reqid = null): array
    {
        $headers = $this->getHeaders($reqid);
        $headers['User-Agent'] = $this->partnerId;
        return $headers;
    }

    protected function post(string $endpoint, array $body = [], bool $withUserAgent = false, ?string $reqid = null): array
    {
        if (empty($this->baseUrl)) {
            Log::warning('SprintVerify API base_url is empty');
            return ['statuscode' => 0, 'message' => __('SprintVerify API is not configured. Set SPRINTVERIFY_BASE_URL in .env.')];
        }
        $url = $this->baseUrl . $endpoint;
        $headers = $withUserAgent ? $this->getHeadersWithUserAgent($reqid) : $this->getHeaders($reqid);
        try {
            $response = Http::timeout($this->timeout)
                ->withOptions(['verify' => $this->verifySsl])
                ->withHeaders($headers)
                ->post($url, $body);
        } catch (\Throwable $e) {
            Log::warning('SprintVerify API request exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['statuscode' => 0, 'message' => $e->getMessage()];
        }
        $data = $response->json();
        if ($response->failed()) {
            Log::warning('SprintVerify API request failed', ['url' => $url, 'status' => $response->status(), 'body' => $data]);
        }
        return is_array($data) ? $data : [];
    }

    protected function postMultipart(string $endpoint, array $fields, UploadedFile $file, string $fileField = 'file', bool $withUserAgent = false, ?string $reqid = null): array
    {
        if (empty($this->baseUrl)) {
            Log::warning('SprintVerify API base_url is empty');
            return ['statuscode' => 0, 'message' => __('SprintVerify API is not configured. Set SPRINTVERIFY_BASE_URL in .env.')];
        }

        $url = $this->baseUrl . $endpoint;
        $headers = $withUserAgent ? $this->getHeadersWithUserAgent($reqid) : $this->getHeaders($reqid);
        unset($headers['Content-Type']);

        try {
            $response = Http::timeout($this->timeout)
                ->withOptions(['verify' => $this->verifySsl])
                ->withHeaders($headers)
                ->attach($fileField, file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->asMultipart()
                ->post($url, $fields);
        } catch (\Throwable $e) {
            Log::warning('SprintVerify multipart request exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['statuscode' => 0, 'message' => $e->getMessage()];
        }

        $data = $response->json();
        if ($response->failed()) {
            Log::warning('SprintVerify multipart request failed', ['url' => $url, 'status' => $response->status(), 'body' => $data]);
        }
        return is_array($data) ? $data : [];
    }

    /**
     * Aadhaar – Send OTP.
     * POST /api/v1/verification/aadhaar_sendotp
     * Body: { "id_number": "644560521706" }
     */
    public function aadhaarSendOtp(string $idNumber, ?string $reqid = null): array
    {
        return $this->post('/api/v1/verification/aadhaar_sendotp', [
            'id_number' => $idNumber,
        ], true, $reqid);
    }

    /**
     * Aadhaar – Verify OTP.
     * POST /api/v1/verification/aadhaar_verifyotp
     * Body: { "client_id": "...", "otp": "999999", "refid": "234534543" }
     */
    public function aadhaarVerifyOtp(string $clientId, string $otp, string $refid, ?string $reqid = null): array
    {
        return $this->post('/api/v1/verification/aadhaar_verifyotp', [
            'client_id' => $clientId,
            'otp'       => $otp,
            'refid'     => $refid,
        ], true, $reqid);
    }

    /**
     * GST Verification.
     * POST /api/v1/verification/gst_verify
     * Body: { "refid": "77672671", "id_number": "27AAACR5055K1Z7" }
     */
    public function gstVerify(string $refid, string $idNumber, ?string $reqid = null): array
    {
        return $this->post('/api/v1/verification/gst_verify', [
            'refid'     => $refid,
            'id_number' => $idNumber,
        ], false, $reqid);
    }

    /**
     * PAN Detailed (PAN details verify).
     * POST /api/v1/verification/pandetails_verify
     * Body: { "refid": "3456790", "id_number": "ABLPI8700M" }
     */
    public function panDetailsVerify(string $refid, string $idNumber, ?string $reqid = null): array
    {
        return $this->post('/api/v1/verification/pandetails_verify', [
            'refid'     => $refid,
            'id_number' => $idNumber,
        ], false, $reqid);
    }

    /**
     * OCR document extraction.
     * POST /api/v1/verification/ocr_doc
     * Multipart fields: type, back, file
     */
    public function ocrDocument(string $type, string $back, UploadedFile $file, ?string $reqid = null): array
    {
        return $this->postMultipart('/api/v1/verification/ocr_doc', [
            'type' => $type,
            'back' => $back,
        ], $file, 'file', true, $reqid);
    }

    /**
     * MCA Verification (Ministry of Corporate Affairs – Company/CIN).
     * POST /api/v1/verification/mca_verify
     * Body: { "refid": "234565767", "id_number": "UP27XXXXXX2849" }
     */
    public function mcaVerify(string $refid, string $idNumber, ?string $reqid = null): array
    {
        return $this->post('/api/v1/verification/mca_verify', [
            'refid'     => $refid,
            'id_number' => $idNumber,
        ], false, $reqid);
    }
}
