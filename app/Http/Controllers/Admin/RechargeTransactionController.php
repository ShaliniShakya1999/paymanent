<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RechargeTransaction;
use Illuminate\Http\Request;

class RechargeTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = RechargeTransaction::with('user:id,first_name,last_name,email');
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
            'menu' => 'recharge',
            'sub_menu' => 'recharge_transactions',
            'transactions' => $transactions,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->get('status', 'all'),
        ];
        return view('admin.recharge.list', $data);
    }

    public function operators(Request $request)
    {
        return view('admin.recharge.operators', [
            'menu' => 'recharge',
            'sub_menu' => 'recharge_operators',
        ]);
    }
}
