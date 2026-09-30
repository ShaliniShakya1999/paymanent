<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillPaymentTransaction;
use Illuminate\Http\Request;

class BillPaymentTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = BillPaymentTransaction::with('user:id,first_name,last_name,email');
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $transactions = $query->orderByDesc('id')->paginate(20)->withQueryString();
        $data = [
            'menu' => 'bbps',
            'sub_menu' => 'bbps_payments',
            'transactions' => $transactions,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->get('status', 'all'),
        ];
        return view('admin.bill_payment.list', $data);
    }
}
