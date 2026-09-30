<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\BillPaymentTransaction;
use App\Services\BillPaymentApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillPaymentController extends Controller
{
    protected BillPaymentApiService $billApi;

    public function __construct(BillPaymentApiService $billApi)
    {
        $this->billApi = $billApi;
    }

    public function index(Request $request)
    {
        return view('user.bbps.dashboard');
    }

    public function getOperators(Request $request): JsonResponse
    {
        $mode = $request->input('mode', 'online');
        $result = $this->billApi->getOperators($mode);
        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message'] ?? __('Failed to load operators.')], 422);
        }
        $data = $result['data'] ?? [];
        if (!is_array($data)) $data = [];
        elseif (isset($data['operators']) && is_array($data['operators'])) $data = $data['operators'];
        elseif (isset($data['list']) && is_array($data['list'])) $data = $data['list'];
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function fetchBill(Request $request): JsonResponse
    {
        $request->validate(['operator' => 'required', 'canumber' => 'required|string|max:50', 'mode' => 'nullable|string|in:online,offline']);
        $operator = $request->input('operator');
        $canumber = $request->input('canumber');
        $mode = $request->input('mode', 'online');
        $extra = $request->only(['ad1', 'ad2', 'ad3']);
        $result = $this->billApi->fetchBill($operator, $canumber, $mode, array_filter($extra));
        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message'] ?? __('Failed to fetch bill.')], 422);
        }
        return response()->json(['success' => true, 'data' => $result['data'] ?? []]);
    }

    public function payBill(Request $request): JsonResponse
    {
        $request->validate([
            'operator' => 'required', 'canumber' => 'required|string|max:50', 'amount' => 'required|numeric|min:1',
            'mode' => 'nullable|string|in:online,offline', 'bill_fetch' => 'required|array',
        ]);
        $userId = $request->user()->id;
        $operator = $request->input('operator');
        $operatorName = $request->input('operator_name', $operator);
        $canumber = $request->input('canumber');
        $amount = (float) $request->input('amount');
        $mode = $request->input('mode', 'online');
        $billFetch = $request->input('bill_fetch');
        $referenceId = 'BIL' . strtoupper(Str::random(8)) . time();
        $payload = [
            'operator' => (string) $operator, 'canumber' => $canumber, 'amount' => (string) $amount,
            'referenceid' => $referenceId, 'latitude' => $request->input('latitude', '0'), 'longitude' => $request->input('longitude', '0'),
            'mode' => $mode, 'bill_fetch' => $billFetch,
        ];
        $payResult = $this->billApi->payBill($payload);
        if (!$payResult['success']) {
            BillPaymentTransaction::create([
                'user_id' => $userId, 'operator_id' => $operator, 'operator_name' => $operatorName, 'canumber' => $canumber,
                'amount' => $amount, 'reference_id' => $referenceId, 'status' => 'api_failed', 'mode' => $mode,
                'bill_fetch' => $billFetch, 'api_request' => $payload, 'api_response' => ['message' => $payResult['message'] ?? 'Bill payment failed.'],
            ]);
            return response()->json(['success' => false, 'message' => $payResult['message'] ?? __('Bill payment failed.')], 422);
        }
        $status = $payResult['status'] ?? 'pending';
        if ($status === 'pending') {
            for ($i = 0; $i < 3; $i++) {
                sleep(1);
                $statusResult = $this->billApi->getStatus($referenceId);
                if ($statusResult['success'] && isset($statusResult['status'])) {
                    $status = $statusResult['status'];
                    if (in_array($status, ['success', 'failed', 'successful', 'failure'], true)) {
                        $status = in_array($status, ['success', 'successful'], true) ? 'success' : 'failed';
                        break;
                    }
                }
            }
        } else {
            $status = in_array($status, ['success', 'successful'], true) ? 'success' : (in_array($status, ['failed', 'failure'], true) ? 'failed' : $status);
        }
        BillPaymentTransaction::create([
            'user_id' => $userId, 'operator_id' => $operator, 'operator_name' => $operatorName, 'canumber' => $canumber,
            'amount' => $amount, 'reference_id' => $referenceId, 'status' => $status, 'mode' => $mode,
            'bill_fetch' => $billFetch, 'api_request' => $payload, 'api_response' => $payResult['data'] ?? null,
        ]);
        return response()->json([
            'success' => $status === 'success', 'status' => $status,
            'message' => $status === 'success' ? __('Bill paid successfully!') : ($status === 'failed' ? __('Bill payment failed.') : __('Payment is processing.')),
            'reference_id' => $referenceId,
        ]);
    }

    public function getStatus(Request $request): JsonResponse
    {
        $request->validate(['referenceid' => 'required|string|max:64']);
        $result = $this->billApi->getStatus($request->input('referenceid'));
        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message'] ?? __('Failed to fetch status.')], 422);
        }
        return response()->json(['success' => true, 'status' => $result['status'] ?? 'pending', 'data' => $result['data'] ?? []]);
    }
}
