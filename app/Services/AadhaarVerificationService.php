<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * PaySprint SprintVerify – Aadhaar OTP send & verify for KYC.
 */
class AadhaarVerificationService
{
    protected string $baseUrl;
    protected string $token;
    protected string $authorisedKey;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = config('sprintverify.base_url');
        $this->token = config('sprintverify.token');
        $this->authorisedKey = config('sprintverify.authorisedkey');
        $this->timeout = config('sprintverify.timeout', 30);
        $this->verifySsl = (bool) config('sprintverify.verify_ssl', true);
    }

    /**
     * Send OTP to Aadhaar-linked mobile number.
     *
     * @param string $aadhaarNumber 12-digit Aadhaar
     * @return array{success: bool, message?: string, data?: array}
     */
    public function sendOtp(string $aadhaarNumber): array
    {
        if (!config('sprintverify.enabled')) {
            return ['success' => false, 'message' => __('Aadhaar OTP service is disabled.')];
        }
        $url = $this->baseUrl . config('sprintverify.paths.send_otp');
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorisedkey' => $this->authorisedKey,
                    'Token' => $this->token,
                    'User-Agent' => config('sprintverify.user_agent', 'CORP00001'),
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])
                ->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())
                ->post($url, ['aadhaar_number' => preg_replace('/\D/', '', $aadhaarNumber)]);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                return ['success' => true, 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Failed to send OTP.');
            Log::warning('SprintVerify sendOtp failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('SprintVerify sendOtp exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Verify Aadhaar OTP.
     *
     * @param string $aadhaarNumber 12-digit Aadhaar
     * @param string $otp OTP entered by user
     * @param string|null $referenceId Optional reference from send OTP response
     * @return array{success: bool, message?: string, data?: array}
     */
    public function verifyOtp(string $aadhaarNumber, string $otp, ?string $referenceId = null): array
    {
        if (!config('sprintverify.enabled')) {
            return ['success' => false, 'message' => __('Aadhaar OTP service is disabled.')];
        }
        $url = $this->baseUrl . config('sprintverify.paths.verify_otp');
        $payload = [
            'aadhaar_number' => preg_replace('/\D/', '', $aadhaarNumber),
            'otp' => $otp,
        ];
        if ($referenceId) {
            $payload['reference_id'] = $referenceId;
        }
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorisedkey' => $this->authorisedKey,
                    'Token' => $this->token,
                    'User-Agent' => config('sprintverify.user_agent', 'CORP00001'),
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])
                ->when(!$this->verifySsl, fn ($r) => $r->withoutVerifying())
                ->post($url, $payload);
            $body = $response->json() ?? [];
            if ($response->successful()) {
                return ['success' => true, 'data' => $body];
            }
            $message = $body['message'] ?? $body['msg'] ?? $response->body() ?: __('Invalid OTP or verification failed.');
            Log::warning('SprintVerify verifyOtp failed', ['url' => $url, 'status' => $response->status(), 'body' => $body]);
            return ['success' => false, 'message' => $message];
        } catch (Exception $e) {
            Log::error('SprintVerify verifyOtp exception', ['url' => $url, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
