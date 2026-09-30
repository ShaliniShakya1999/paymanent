<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\AepsTransaction;
use App\Services\AepsApiService;
use App\Helpers\ReferenceIdHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AepsController extends Controller
{
    protected AepsApiService $api;

    public function __construct(AepsApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        if (!config('aeps.enabled')) {
            return redirect()->route('user.dashboard')->with('warning', __('AEPS is currently disabled.'));
        }
        return view('user.aeps.index', [
            'menu' => 'aeps',
            'icon' => 'wallet2',
            'content_title' => __('AEPS (Aadhaar Enabled Payment System)'),
        ]);
    }

    public function getBanks()
    {
        $result = $this->api->getBankList();
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? '',
            'banks' => $result['banks'] ?? [],
        ]);
    }

    public function twoFactorAuth(Request $request)
    {
        $request->validate(['type' => 'required|string|in:send,verify']);
        $result = $this->api->twoFactorAuth($request->type, $request->all());
        return response()->json($result);
    }

    public function register(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|string|max:64',
            'bank_name' => 'nullable|string|max:191',
            'aadhaar_number' => 'required|string|size:12|regex:/^[0-9]{12}$/',
            'mobile' => 'nullable|string|max:20',
            'transaction_type' => 'nullable|string|max:50',
            'pid_data' => 'nullable|string',
        ]);
        return response()->json($this->api->register($request->only([
            'bank_id',
            'bank_name',
            'aadhaar_number',
            'mobile',
            'transaction_type',
            'pid_data',
        ])));
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|string|max:64',
            'bank_name' => 'nullable|string|max:191',
            'aadhaar_number' => 'required|string|size:12|regex:/^[0-9]{12}$/',
            'mobile' => 'nullable|string|max:20',
            'transaction_type' => 'nullable|string|max:50',
            'pid_data' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);
        $referenceId = ReferenceIdHelper::forAeps();
        $aadhaar = $request->aadhaar_number;
        $masked = strlen($aadhaar) >= 4 ? 'XXXXXX' . substr($aadhaar, -4) : 'XXXX';
        $result = $this->api->authenticate([
            'reference_id' => $referenceId,
            'bank_id' => $request->bank_id,
            'bank_name' => $request->bank_name,
            'aadhaar_number' => $aadhaar,
            'mobile' => $request->mobile,
            'transaction_type' => $request->transaction_type,
            'pid_data' => $request->pid_data,
            'amount' => (float) $request->amount,
        ]);
        $status = ($result['success'] ?? false) ? 'success' : 'failed';
        AepsTransaction::create([
            'user_id' => Auth::id(),
            'reference_id' => $referenceId,
            'bank_id' => $request->bank_id,
            'bank_name' => $request->bank_name,
            'aadhaar_masked' => $masked,
            'amount' => $request->amount,
            'api_response' => $result,
            'status' => $status,
        ]);
        return response()->json(array_merge($result, ['reference_id' => $referenceId]));
    }

    public function getStatus(Request $request)
    {
        $ref = $request->get('reference_id');
        if (!$ref) {
            return response()->json(['success' => false, 'message' => __('Reference ID required.')], 422);
        }
        return response()->json($this->api->getStatus($ref));
    }
}
