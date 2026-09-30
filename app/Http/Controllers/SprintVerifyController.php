<?php

namespace App\Http\Controllers;

use App\Services\SprintVerifyApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SprintVerifyController extends Controller
{
    protected SprintVerifyApiService $service;

    public function __construct(SprintVerifyApiService $service)
    {
        $this->service = $service;
    }

    /**
     * Show MCA verification form (UI).
     */
    public function mcaVerifyPage()
    {
        $data = [
            'content_title' => __('MCA Verification'),
            'menu'          => 'verification',
        ];
        return view('user.verification.mca', $data);
    }

    /**
     * Show PAN OCR form (UI).
     */
    public function panOcrPage()
    {
        $data = [
            'content_title' => __('PAN OCR'),
            'menu'          => 'verification',
        ];
        return view('user.verification.pan-ocr', $data);
    }

    /**
     * Aadhaar – Send OTP.
     * POST body: { "id_number": "644560521706" }
     * Returns normalized: success, message, client_id, refid (for use in verify).
     */
    public function aadhaarSendOtp(Request $request)
    {
        try {
            $request->validate(['id_number' => 'required|string|size:12|regex:/^[0-9]{12}$/']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()['id_number'][0] ?? __('Invalid Aadhaar number.')], 422);
        }

        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));
        try {
            $result = $this->service->aadhaarSendOtp($request->id_number, $reqid);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('SprintVerify send OTP error', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => __('Request failed. Check SprintVerify config (base_url, authorised key, JWT secret) and try again.'),
            ]);
        }

        $code = (int) ($result['statuscode'] ?? $result['status_code'] ?? $result['response_code'] ?? 0);
        $data = $result['data'] ?? $result;
        $clientId = $data['client_id'] ?? $result['client_id'] ?? '';
        $refid = $data['refid'] ?? $result['refid'] ?? $reqid;
        $success = ($code === 200 || $code === 1) || !empty($result['status']) || ($clientId !== '');

        return response()->json([
            'success'   => $success,
            'message'   => $result['message'] ?? ($success ? __('OTP sent successfully.') : __('Failed to send OTP.')),
            'client_id' => $clientId,
            'refid'     => $refid,
            'response_code' => $code,
        ]);
    }

    /**
     * Aadhaar – Verify OTP.
     * POST body: { "client_id": "...", "otp": "999999", "refid": "...", "aadhaar_number": "..." (optional, for KYC) }
     * On success, if aadhaar_number present, sets session for KYC step 1.
     */
    public function aadhaarVerifyOtp(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'otp'       => 'required|string|max:10',
            'refid'     => 'required|string',
            'aadhaar_number' => 'nullable|string|size:12|regex:/^[0-9]{12}$/',
        ]);
        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));
        $result = $this->service->aadhaarVerifyOtp(
            $request->client_id,
            $request->otp,
            $request->refid,
            $reqid
        );

        $code = (int) ($result['statuscode'] ?? $result['status_code'] ?? $result['response_code'] ?? 0);
        $success = ($code === 200 || $code === 1) || !empty($result['status']);

        if ($success && $request->filled('aadhaar_number')) {
            Session::put('kyc_aadhaar_verified_number', $request->aadhaar_number);
        }

        return response()->json([
            'success'       => $success,
            'message'       => $result['message'] ?? ($success ? __('Aadhaar verified successfully.') : __('OTP verification failed.')),
            'response_code' => $code,
        ]);
    }

    /**
     * GST Verification.
     * POST body: { "refid": "...", "id_number": "27AAACR5055K1Z7" }
     */
    public function gstVerify(Request $request)
    {
        $request->validate([
            'refid'     => 'required|string',
            'id_number' => 'required|string|max:20',
        ]);
        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));
        $result = $this->service->gstVerify($request->refid, $request->id_number, $reqid);
        return response()->json($result);
    }

    /**
     * PAN Detailed (PAN details verify).
     * POST body: { "refid": "...", "id_number": "ABLPI8700M" }
     * PaySprint returns: statuscode 200, status true, message, data (fullName, idStatus, etc.)
     */
    public function panDetailsVerify(Request $request)
    {
        $request->validate([
            'refid'     => 'required|string|max:64',
            'id_number' => 'required|string|max:20',
        ]);
        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));
        try {
            $result = $this->service->panDetailsVerify($request->refid, $request->id_number, $reqid);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('SprintVerify PAN verify error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
        $code = (int) ($result['statuscode'] ?? $result['status_code'] ?? 0);
        $success = ($code === 200 || $code === 1) || !empty($result['status']);
        $data = $result['data'] ?? $result;
        return response()->json([
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('PAN details verified.') : __('Verification failed.')),
            'data'    => $data,
        ]);
    }

    public function panOcrVerify(Request $request)
    {
        $request->validate([
            'type'      => 'required|string|in:PAN',
            'back'      => 'required|string|in:front,back,both',
            'document'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));

        try {
            $result = $this->service->ocrDocument(
                $request->input('type', 'PAN'),
                $request->input('back', 'both'),
                $request->file('document'),
                $reqid
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('SprintVerify OCR verify error', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        $code = (int) ($result['statuscode'] ?? $result['status_code'] ?? 0);
        $success = ($code === 200 || $code === 1) || !empty($result['status']);
        $data = $result['data'] ?? [];

        return response()->json([
            'success'      => $success,
            'message'      => $result['message'] ?? ($success ? __('PAN OCR verified successfully.') : __('PAN OCR failed.')),
            'reference_id' => $result['reference_id'] ?? null,
            'data'         => $data,
            'raw'          => $result,
        ]);
    }

    /**
     * MCA Verification (Company/CIN).
     * POST body: { "refid": "...", "id_number": "UP27XXXXXX2849" }
     */
    public function mcaVerify(Request $request)
    {
        $request->validate([
            'refid'     => 'required|string|max:64',
            'id_number' => 'required|string|max:64',
        ]);
        $reqid = $request->input('reqid') ?: (string) (time() . rand(100000, 999999));
        try {
            $result = $this->service->mcaVerify($request->refid, $request->id_number, $reqid);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('SprintVerify MCA verify error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
        $code = (int) ($result['statuscode'] ?? $result['status_code'] ?? 0);
        $success = ($code === 200 || $code === 1) || !empty($result['status']);
        $data = $result['data'] ?? $result;
        return response()->json([
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('MCA verification successful.') : __('MCA verification failed.')),
            'reference_id' => $result['reference_id'] ?? null,
            'data'    => $data,
            'raw'     => $result,
        ]);
    }
}
