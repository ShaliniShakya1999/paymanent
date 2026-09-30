<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AepsTransaction;
use Illuminate\Http\Request;

class AepsTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = AepsTransaction::with('user:id,first_name,last_name,email');
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
        return view('admin.aeps.transactions', [
            'menu' => 'aeps',
            'sub_menu' => 'aeps_transactions',
            'transactions' => $transactions,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->get('status', 'all'),
        ]);
    }

    public function logs(Request $request)
    {
        $query = AepsTransaction::with('user:id,first_name,last_name,email');
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $logs = $query->orderByDesc('id')->paginate(20)->withQueryString();
        return view('admin.aeps.logs', [
            'menu' => 'aeps',
            'sub_menu' => 'aeps_logs',
            'logs' => $logs,
            'from' => $request->from,
            'to' => $request->to,
        ]);
    }
}
