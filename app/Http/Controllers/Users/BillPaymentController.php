<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\BillPaymentTransaction;
use App\Services\BillPaymentApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillPaymentController extends Controller
{
    protected BillPaymentApiService $api;

    public function __construct(BillPaymentApiService $api)
    {
        $this->api = $api;
    }

    protected function normalizeAuthMessage(array $result): string
    {
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);
        if ($code === 0 || $code === 401 || $code === 403) {
            return __('API authentication failed. Please check Bill Payment credentials in settings.');
        }
        if ($code === 18) {
            return __('Duplicate transaction. This reference has already been used.');
        }
        return $result['message'] ?? __('Something went wrong. Please try again.');
    }

    public function index()
    {
        if (!config('bill_payment.enabled')) {
            return redirect()->route('user.dashboard')->with('warning', __('Bill Payment is currently disabled.'));
        }
        $data = [
            'menu'          => 'bill_payment',
            'icon'          => 'receipt',
            'content_title' => __('Bill Payment (BBPS)'),
        ];
        return view('user.bbps.dashboard', $data);
    }

    public function getOperators(Request $request)
    {
        $mode = (string) $request->get('mode', '');
        $result = $this->api->getOperators($mode);
        $code = (int) ($result['response_code'] ?? 0);
        if ($code !== 1) {
            return response()->json([
                'success' => false,
                'message' => $this->normalizeAuthMessage($result),
                'operators' => [],
            ], 200);
        }
        $operators = $result['operators'] ?? [];
        $categories = [];
        foreach ($operators as $op) {
            $cat = $op['category'] ?? $op['operator_type'] ?? 'Other';
            if (!in_array($cat, $categories)) {
                $categories[] = $cat;
            }
        }
        sort($categories);
        return response()->json([
            'success'    => true,
            'operators'  => $operators,
            'categories' => $categories,
        ]);
    }

    public function fetchBill(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|string|max:64',
            'consumer_number' => 'required|string|max:64',
            'mode' => 'nullable|string|max:32',
        ]);
        $result = $this->api->fetchBill(
            $request->operator_id,
            $request->consumer_number,
            $request->get('mode', '')
        );
        $code = (int) ($result['response_code'] ?? 0);
        if ($code !== 1) {
            return response()->json([
                'success' => false,
                'message' => $this->normalizeAuthMessage($result),
                'bill_fetch' => null,
                'amount' => null,
            ], 200);
        }
        return response()->json([
            'success'   => true,
            'message'   => $result['message'] ?? __('Bill fetched successfully.'),
            'bill_fetch' => $result['bill_fetch'],
            'amount'    => $result['amount'],
            'data'      => $result['data'] ?? [],
        ]);
    }

    public function payBill(Request $request)
    {
        $request->validate([
            'operator_id'    => 'required|string|max:64',
            'consumer_number'=> 'required|string|max:64',
            'amount'         => 'required|numeric|min:0',
            'bill_fetch'     => 'required|string',
            'mode'           => 'nullable|string|max:32',
            'operator_name' => 'nullable|string|max:191',
            'category'       => 'nullable|string|max:64',
            'latitude'       => 'nullable|string|max:32',
            'longitude'      => 'nullable|string|max:32',
        ]);
        $referenceId = 'BIL' . time() . rand(1000, 9999);
        $payload = [
            'operator'    => $request->operator_id,
            'canumber'    => $request->consumer_number,
            'amount'      => (float) $request->amount,
            'referenceid' => $referenceId,
            'mode'        => $request->get('mode', ''),
            'bill_fetch'  => $request->bill_fetch,
        ];
        if ($request->filled('latitude')) {
            $payload['latitude'] = $request->latitude;
        } else {
            $payload['latitude'] = config('bill_payment.default_latitude', '0');
        }
        if ($request->filled('longitude')) {
            $payload['longitude'] = $request->longitude;
        } else {
            $payload['longitude'] = config('bill_payment.default_longitude', '0');
        }
        $result = $this->api->payBill($payload);
        $code = (int) ($result['response_code'] ?? $result['responsecode'] ?? 0);

        $status = ($code === 1) ? 'success' : 'failed';
        BillPaymentTransaction::create([
            'user_id'         => Auth::id(),
            'reference_id'    => $referenceId,
            'operator_id'     => $request->operator_id,
            'operator_name'   => $request->operator_name,
            'category'        => $request->category,
            'consumer_number' => $request->consumer_number,
            'amount'          => $request->amount,
            'bill_fetch'      => $request->bill_fetch,
            'mode'            => $request->mode,
            'api_response'    => $result,
            'status'          => $status,
        ]);

        if ($code !== 1) {
            return response()->json([
                'success' => false,
                'message' => $this->normalizeAuthMessage($result),
                'reference_id' => $referenceId,
            ], 200);
        }
        return response()->json([
            'success'      => true,
            'message'      => $result['message'] ?? __('Bill paid successfully.'),
            'reference_id' => $referenceId,
            'data'         => $result['data'] ?? $result,
        ]);
    }

    public function getStatus(Request $request)
    {
        $referenceId = $request->get('reference_id');
        if (!$referenceId) {
            return response()->json(['success' => false, 'message' => __('Reference ID required.')], 422);
        }
        $result = $this->api->getStatus($referenceId);
        return response()->json($result);
    }
}
