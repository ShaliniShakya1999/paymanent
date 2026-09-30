<?php

namespace App\DataTables\Admin;

use Yajra\DataTables\Services\DataTable;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AepsAgentsDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('user_details', function ($user) {
                $name = getColumnValue($user);
                $email = $user->email ?? '-';
                $link = url(config('adminPrefix') . '/users/edit/' . $user->id);
                return '<div><strong>' . e($name) . '</strong><br><small class="text-muted">' . e($email) . '</small></div>';
            })
            ->addColumn('agent_details', function ($user) {
                return '-';
            })
            ->addColumn('details', function ($user) {
                $phone = !empty($user->formattedPhone) ? $user->formattedPhone : '-';
                $created = $user->created_at ? $user->created_at->format('d M Y') : '-';
                return '<div><small>Phone: ' . e($phone) . '</small><br><small>Joined: ' . e($created) . '</small></div>';
            })
            ->addColumn('status', function ($user) {
                return getStatusLabel($user->status);
            })
            ->rawColumns(['user_details', 'agent_details', 'details', 'status'])
            ->make(true);
    }

    public function query()
    {
        $from = request()->filled('from') ? setDateForDb(request()->from) : null;
        $to = request()->filled('to') ? setDateForDb(request()->to) : null;
        $searchValue = request()->filled('search_value') ? trim(request()->search_value) : null;
        $userId = request()->filled('user_id') ? trim(request()->user_id) : null;
        $status = request()->filled('status') && request()->status !== '' && request()->status !== 'all' ? request()->status : null;

        $query = User::with(['role:id,display_name', 'user_detail:id,user_id'])
            ->select('users.*')
            ->where('users.id', '!=', 1);

        if ($from) {
            $query->whereDate('users.created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('users.created_at', '<=', $to);
        }
        if ($userId) {
            $query->where('users.id', $userId);
        }
        if ($status !== null) {
            $query->where('users.status', $status);
        }
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.last_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.phone', 'like', '%' . $searchValue . '%');
            });
        }

        return $this->applyScopes($query);
    }

    public function html()
    {
        $builder = $this->builder()
            ->ajax(url()->full())
            ->addColumn(['data' => 'id', 'name' => 'users.id', 'title' => '#', 'orderable' => true, 'searchable' => false])
            ->addColumn(['data' => 'user_details', 'name' => 'user_details', 'title' => __('USER DETAILS'), 'orderable' => false, 'searchable' => true])
            ->addColumn(['data' => 'agent_details', 'name' => 'agent_details', 'title' => __('AGENT DETAILS'), 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'details', 'name' => 'details', 'title' => __('DETAILS'), 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'status', 'name' => 'users.status', 'title' => __('STATUS'), 'orderable' => true, 'searchable' => false]);
        return $builder->parameters(dataTableOptions());
    }
}
