<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Transaction,
    Wallet
};

class UserTransactionController extends Controller
{
    public function index()
    {
        $transaction      = new Transaction();
        $data['menu']     = 'transactions';
        $data['sub_menu'] = 'transactions';

        $data['from']     = $from   = isset(request()->from) ? setDateForDb(request()->from) : null;
        $data['to']       = $to     = isset(request()->to ) ? setDateForDb(request()->to) : null;
        $data['status']   = $status = isset(request()->status) ? request()->status : 'all';
        $data['type']     = $type   = isset(request()->type) ? request()->type : 'all';
        $data['wallet']   = $wallet = isset(request()->wallet) ? request()->wallet : 'all';

        $data['transactions'] = $transaction->getTransactions($from, $to, $type, $wallet, $status);

        $data['wallets'] = Wallet::with(['currency:id,code'])->where(['user_id' => auth()->user()->id])->get(['currency_id']);
        $data['transactionTypes'] = getTransactionTypes();
        $data['statuses'] = Transaction::select('status')->distinct()->get();

        return view('user.transaction.index', $data);
    }


    /**
     * Generate pdf print for exchangeTransaction entries
     */
    public function exchangeTransactionPrintPdf($id)
    {
        $data['transaction'] = $transaction = Transaction::with([
            'currency:id,code,symbol',
        ])->where(['id' => $id])->first();
        
        generatePDF('user.exchange-currency.exchange-transaction-pdf', 'exchange_', $data);
    }

    /**
     * Generate pdf print for merchant payment entries
     */
    public function merchantPaymentTransactionPrintPdf($id)
    {
        $data['transaction'] = Transaction::with([
            'merchant:id,business_name',
            'currency:id,symbol,code',
        ])->where(['id' => $id])->first();

        generatePDF('user.merchant.merchant-payment-pdf', 'merchant-payment_', $data);
    }

    /**
     * Show transaction details
     */
    public function showDetails($id)
    {
        return redirect()->route('user.transactions.index');
    }

    /**
     * Get transaction by AJAX
     */
    public function getTransaction(Request $request)
    {
        $transaction = Transaction::with([
            'currency:id,code,symbol',
            'user:id,first_name,last_name',
            'end_user:id,first_name,last_name',
            'payment_method:id,name',
        ])->find($request->id);

        return response()->json([
            'status' => (bool) $transaction,
            'transaction' => $transaction
        ]);
    }

    /**
     * Generate general transaction PDF or delegate to specific print route
     */
    public function getTransactionPrintPdf($id)
    {
        $transaction = Transaction::with([
            'currency:id,code,symbol',
            'user:id,first_name,last_name',
            'end_user:id,first_name,last_name',
            'payment_method:id,name',
        ])->where(['id' => $id])->first();

        if (!$transaction) {
            (new \App\Http\Helpers\Common())->one_time_message('error', __('Transaction not found.'));
            return redirect()->route('user.transactions.index');
        }

        $info = getTransactionInfo($transaction->transaction_type?->name, $transaction);
        if (isset($info['print']) && $info['print'] !== 'user.transactions.print' && \Route::has($info['print'])) {
            return redirect()->route($info['print'], $id);
        }

        $data['transaction'] = $transaction;
        generatePDF('user.exchange-currency.exchange-transaction-pdf', 'transaction_', $data);
    }
}