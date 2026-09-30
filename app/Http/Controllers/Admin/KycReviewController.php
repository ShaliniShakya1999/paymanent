<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\DocumentVerification;
use App\Models\KycPartner;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;

class KycReviewController extends Controller
{
    protected $helper;

    public function __construct(Common $helper)
    {
        $this->helper = $helper;
    }

    public function index(Request $request)
    {
        $data['menu'] = 'kyc';
        $data['sub_menu'] = 'kyc_list';

        $query = UserDetail::query()
            ->with('user:id,first_name,last_name,email')
            ->whereNotNull('merchant_category');

        $status = $request->get('status', 'in_review');
        if ($status && $status !== 'all') {
            $query->where('kyc_status', $status);
        }

        $data['submissions'] = $query->orderBy('kyc_submitted_at', 'desc')->paginate(20)->withQueryString();
        $data['status_filter'] = $status;
        $data['statuses'] = config('kyc.statuses', []);

        return view('admin.kyc.index', $data);
    }

    public function show($id)
    {
        $user = User::with('user_detail')->findOrFail($id);
        $detail = $user->user_detail;

        if (!$detail || !$detail->merchant_category) {
            $this->helper->one_time_message('error', __('User has not started KYC.'));
            return redirect()->route('admin.kyc.index');
        }

        $data['menu'] = 'kyc';
        $data['sub_menu'] = 'kyc_list';
        $data['user'] = $user;
        $data['detail'] = $detail;
        $data['documents'] = DocumentVerification::where('user_id', $user->id)
            ->whereNotNull('document_type')
            ->with('file')
            ->orderBy('document_type')
            ->get();
        $data['entity_config'] = config('kyc.entities.' . $detail->merchant_category, []);
        $data['partners'] = $detail->merchant_category === 'partnership'
            ? KycPartner::where('user_id', $user->id)->with(['aadhaarFile', 'panFile'])->orderBy('sort_order')->get()
            : collect();

        return view('admin.kyc.show', $data);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $detail = $user->user_detail;

        if (!$detail) {
            $this->helper->one_time_message('error', __('User details not found.'));
            return redirect()->route('admin.kyc.index');
        }

        $detail->kyc_status = 'approved';
        $detail->kyc_reviewed_at = now();
        $detail->kyc_rejection_reason = null;
        $detail->save();

        DocumentVerification::where('user_id', $user->id)->whereNotNull('document_type')->update(['status' => 'approved']);

        $this->helper->one_time_message('success', __('KYC approved. User can now access the dashboard.'));
        return redirect()->route('admin.kyc.show', $id);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'kyc_rejection_reason' => ['required', 'string', 'max:1000'],
        ], [], ['kyc_rejection_reason' => __('Reason')]);

        $user = User::findOrFail($id);
        $detail = $user->user_detail;

        if (!$detail) {
            $this->helper->one_time_message('error', __('User details not found.'));
            return redirect()->route('admin.kyc.index');
        }

        $detail->kyc_status = 'rejected';
        $detail->kyc_reviewed_at = now();
        $detail->kyc_rejection_reason = $request->kyc_rejection_reason;
        $detail->save();

        DocumentVerification::where('user_id', $user->id)->whereNotNull('document_type')->update(['status' => 'rejected']);

        $this->helper->one_time_message('success', __('KYC rejected. User can submit again.'));
        return redirect()->route('admin.kyc.show', $id);
    }
}
