<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\RechargeTransaction;
use App\Services\RechargeApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RechargeController extends Controller
{
    protected RechargeApiService $api;

    public function __construct(RechargeApiService $api)
    {
        $this->api = $api;
    }

    protected function normalizeAuthMessage(array $result): string
    {
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        if ($code === 0 || $code === 401 || $code === 403) {
            return __('API authentication failed. Please check Recharge credentials in settings.');
        }
        if ($code === 18) {
            return __('Duplicate reference id. This reference has already been used.');
        }
        return $result['message'] ?? __('Something went wrong. Please try again.');
    }

    public function index()
    {
        if (!config('recharge.enabled')) {
            return redirect()->route('user.dashboard')->with('warning', __('Recharge is currently disabled.'));
        }
        $data = [
            'menu'          => 'recharge',
            'icon'          => 'phone',
            'content_title' => __('Recharge (Mobile / DTH)'),
        ];
        return view('user.recharge.index', $data);
    }

    public function getOperators()
    {
        $result = $this->api->getOperators();
        $code = (int) ($result['response_code'] ?? 0);
        if ($code !== 1) {
            return response()->json([
                'success'   => false,
                'message'   => $this->normalizeAuthMessage($result),
                'operators' => [],
            ], 200);
        }
        return response()->json([
            'success'   => true,
            'operators' => $result['operators'] ?? [],
        ]);
    }

    public function doRecharge(Request $request)
    {
        $request->validate([
            'operator_id'    => 'required|integer',
            'mobile_number'  => 'required|string|max:20',
            'amount'         => 'required|numeric|min:1',
            'operator_name'  => 'nullable|string|max:191',
        ]);
        $referenceId = $this->generateUniqueReferenceId();
        $result = $this->api->doRecharge(
            $request->operator_id,
            $request->mobile_number,
            (float) $request->amount,
            $referenceId
        );

        $status = $result['status'] ? 'success' : 'failed';
        RechargeTransaction::create([
            'user_id'       => Auth::id(),
            'reference_id'  => $referenceId,
            'operator_id'   => $request->operator_id,
            'operator_name' => $request->operator_name,
            'mobile_number' => $request->mobile_number,
            'amount'        => $request->amount,
            'api_response'  => $result,
            'status'        => $status,
        ]);

        if ($result['status']) {
            return response()->json([
                'success'      => true,
                'message'      => $result['message'] ?? __('Recharge initiated successfully.'),
                'reference_id' => $referenceId,
                'data'         => $result['data'] ?? $result,
            ]);
        }

        $pendingStatus = $result['data']['status'] ?? null;
        if (strtolower((string) $pendingStatus) === 'pending') {
            $poll = $this->pollStatus($referenceId);
            if (isset($poll['status'])) {
                $status = strtolower((string) $poll['status']);
                if ($status === 'success' || $status === 'refunded') {
                    RechargeTransaction::where('reference_id', $referenceId)->update([
                        'status' => $status,
                        'api_response' => array_merge($result, ['poll' => $poll]),
                    ]);
                    return response()->json([
                        'success'      => true,
                        'message'      => $status === 'refunded' ? __('Recharge refunded.') : __('Recharge successful.'),
                        'reference_id' => $referenceId,
                        'status'       => $status,
                        'data'         => $poll,
                    ]);
                }
            }
        }

        return response()->json([
            'success'      => false,
            'message'      => $this->normalizeAuthMessage($result),
            'reference_id' => $referenceId,
            'data'         => $result['data'] ?? $result,
        ]);
    }

    protected function generateUniqueReferenceId(): string
    {
        // Ensure every recharge gets a fresh reference id.
        do {
            $referenceId = 'RCH' . now()->format('YmdHisv') . strtoupper(Str::random(4));
        } while (RechargeTransaction::where('reference_id', $referenceId)->exists());

        return $referenceId;
    }

    protected function pollStatus(string $referenceId, int $maxAttempts = 10): array
    {
        for ($i = 0; $i < $maxAttempts; $i++) {
            sleep(2);
            $result = $this->api->getStatus($referenceId);
            $status = $result['data']['status'] ?? $result['status'] ?? null;
            if (in_array(strtolower((string) $status), ['success', 'failed', 'refunded'])) {
                return $result['data'] ?? $result;
            }
        }
        return [];
    }

    public function getStatusEnquiry(Request $request)
    {
        $referenceId = $request->get('reference_id');
        if (!$referenceId) {
            return response()->json(['success' => false, 'message' => __('Reference ID required.')], 422);
        }
        $result = $this->api->getStatus($referenceId);
        return response()->json($result);
    }
}
