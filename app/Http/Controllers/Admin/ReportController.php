<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillPaymentTransaction;
use App\Models\RechargeTransaction;
use App\Models\AepsTransaction;
use App\Models\BusBookingTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));
        $dates = function ($q) use ($from, $to) {
            $q->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        };
        $billPayment = BillPaymentTransaction::where($dates)->get();
        $recharge = RechargeTransaction::where($dates)->get();
        $aeps = AepsTransaction::where($dates)->get();
        $bus = BusBookingTransaction::where($dates)->get();
        $data = [
            'menu' => 'reports',
            'sub_menu' => 'reports_transactions',
            'from' => $from,
            'to' => $to,
            'bill_payment' => $billPayment,
            'recharge' => $recharge,
            'aeps' => $aeps,
            'bus' => $bus,
        ];
        return view('admin.reports.transactions', $data);
    }

    public function apiLogs(Request $request)
    {
        $from = $request->get('from', now()->subDays(7)->format('Y-m-d'));
        $to = $request->get('to', now()->format('Y-m-d'));
        $logs = [];
        if (class_exists(\App\Models\ApiLog::class)) {
            $logs = \App\Models\ApiLog::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->orderByDesc('id')
                ->paginate(50)
                ->withQueryString();
        }
        return view('admin.reports.api_logs', [
            'menu' => 'reports',
            'sub_menu' => 'reports_api_logs',
            'logs' => $logs,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
