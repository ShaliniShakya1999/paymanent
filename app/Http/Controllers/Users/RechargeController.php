<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\RechargeTransaction;
use App\Services\RechargeApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RechargeController extends Controller
{
    protected RechargeApiService $rechargeApi;

    public function __construct(RechargeApiService $rechargeApi)
    {
        $this->rechargeApi = $rechargeApi;
    }

    public function index(Request $request)
    {
        return view('user.recharge.index');
    }

    public function getOperators(Request $request): JsonResponse
    {
        $result = $this->rechargeApi->getOperators();
        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message'] ?? __('Failed to load operators.')], 422);
        }
        $data = $result['data'] ?? [];
        if (!is_array($data)) $data = [];
        elseif (isset($data['operators']) && is_array($data['operators'])) $data = $data['operators'];
        elseif (isset($data['list']) && is_array($data['list'])) $data = $data['list'];
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function doRecharge(Request $request): JsonResponse
    {
        $request->validate([
            'operator' => 'required|string|max:100',
            'mobile'   => 'required|string|regex:/^[6-9]\d{9}$/|max:10',
            'amount'   => 'required|numeric|min:10',
        ], ['mobile.regex' => __('Enter a valid 10-digit mobile number.')]);

        $userId = $request->user()->id;
        $operator = $request->input('operator');
        $operatorName = $request->input('operator_name', $operator);
        $mobile = $request->input('mobile');
        $amount = (float) $request->input('amount');
        $referenceId = 'RCH' . strtoupper(Str::random(8)) . time();

        $doResult = $this->rechargeApi->doRecharge($operator, $mobile, $amount, $referenceId);

        if (!$doResult['success']) {
            RechargeTransaction::create([
                'user_id' => $userId, 'operator_id' => $operator, 'operator_name' => $operatorName,
                'mobile' => $mobile, 'amount' => $amount, 'reference_id' => $referenceId, 'status' => 'api_failed',
                'api_request' => ['operator' => $operator, 'canumber' => $mobile, 'amount' => $amount, 'referenceid' => $referenceId],
                'api_response' => ['message' => $doResult['message'] ?? 'Recharge request failed.'],
            ]);
            return response()->json(['success' => false, 'message' => $doResult['message'] ?? __('Recharge request failed.')], 422);
        }

        $status = $doResult['status'] ?? 'pending';
        if ($status === 'pending') {
            for ($i = 0; $i < 3; $i++) {
                sleep(1);
                $statusResult = $this->rechargeApi->getStatus($referenceId);
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

        RechargeTransaction::create([
            'user_id' => $userId, 'operator_id' => $operator, 'operator_name' => $operatorName,
            'mobile' => $mobile, 'amount' => $amount, 'reference_id' => $referenceId, 'status' => $status,
            'api_request' => ['operator' => $operator, 'canumber' => $mobile, 'amount' => $amount, 'referenceid' => $referenceId],
            'api_response' => $doResult['data'] ?? null,
        ]);

        return response()->json([
            'success' => $status === 'success',
            'status' => $status,
            'message' => $status === 'success' ? __('Recharge successful!') : ($status === 'failed' ? __('Recharge failed.') : __('Recharge is processing.')),
            'reference_id' => $referenceId,
        ]);
    }
}
