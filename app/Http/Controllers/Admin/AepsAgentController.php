<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\AepsAgentsDataTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AepsAgentsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AepsAgentController extends Controller
{
    public function index(AepsAgentsDataTable $dataTable)
    {
        $data = [
            'menu' => 'aeps',
            'sub_menu' => 'aeps_agent_list',
            'from' => request()->get('from'),
            'to' => request()->get('to'),
            'search_value' => request()->get('search_value'),
            'user_id' => request()->get('user_id'),
            'status' => request()->get('status', 'all'),
        ];
        return $dataTable->render('admin.aeps.agent_list', $data);
    }

    public function excel(Request $request): BinaryFileResponse
    {
        $from = $request->filled('from') ? setDateForDb($request->from) : null;
        $to = $request->filled('to') ? setDateForDb($request->to) : null;
        $searchValue = $request->filled('search_value') ? trim($request->search_value) : null;
        $userId = $request->filled('user_id') ? trim($request->user_id) : null;
        $status = $request->filled('status') && $request->status !== '' && $request->status !== 'all' ? $request->status : null;

        return Excel::download(
            new AepsAgentsExport($from, $to, $searchValue, $userId, $status),
            'aeps_agent_list_' . date('Y-m-d_His') . '.xlsx'
        );
    }
}
