<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BillPaymentApiService;
use Illuminate\Http\Request;

class BbpsAdminController extends Controller
{
    protected BillPaymentApiService $api;

    public function __construct(BillPaymentApiService $api)
    {
        $this->api = $api;
    }

    public function operators(Request $request)
    {
        $result = $this->api->getOperators('online/offline');
        $operators = $result['operators'] ?? [];
        $categories = [];
        foreach ($operators as $op) {
            $cat = $op['category'] ?? 'Other';
            if (!in_array($cat, $categories)) $categories[] = $cat;
        }
        sort($categories);
        return view('admin.bbps.operators', [
            'menu' => 'bbps', 'sub_menu' => 'bbps_operators',
            'operators' => $operators, 'categories' => $categories,
        ]);
    }

    public function statusEnquiry(Request $request)
    {
        $result = null;
        if ($request->isMethod('post') && $request->filled('referenceid')) {
            $result = $this->api->getStatus($request->referenceid);
        }
        return view('admin.bbps.status_enquiry', [
            'menu' => 'bbps', 'sub_menu' => 'bbps_status', 'result' => $result,
        ]);
    }
}
