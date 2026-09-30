<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class AepsAgentsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $from;
    protected $to;
    protected $searchValue;
    protected $userId;
    protected $status;

    public function __construct($from = null, $to = null, $searchValue = null, $userId = null, $status = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->searchValue = $searchValue;
        $this->userId = $userId;
        $this->status = $status;
    }

    public function query()
    {
        $query = User::with(['role:id,display_name'])
            ->select('users.*')
            ->where('users.id', '!=', 1);

        if ($this->from) {
            $query->whereDate('users.created_at', '>=', $this->from);
        }
        if ($this->to) {
            $query->whereDate('users.created_at', '<=', $this->to);
        }
        if ($this->userId) {
            $query->where('users.id', $this->userId);
        }
        if ($this->status !== null) {
            $query->where('users.status', $this->status);
        }
        if ($this->searchValue) {
            $query->where(function ($q) {
                $q->where('users.first_name', 'like', '%' . $this->searchValue . '%')
                    ->orWhere('users.last_name', 'like', '%' . $this->searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $this->searchValue . '%')
                    ->orWhere('users.phone', 'like', '%' . $this->searchValue . '%');
            });
        }

        return $query->orderBy('users.id', 'desc');
    }

    public function headings(): array
    {
        return ['#', __('User'), __('Email'), __('Phone'), __('Details'), __('Status')];
    }

    public function map($user): array
    {
        $phone = !empty($user->formattedPhone) ? $user->formattedPhone : '-';
        $created = $user->created_at ? $user->created_at->format('d M Y') : '-';
        return [
            $user->id,
            getColumnValue($user),
            $user->email ?? '-',
            $phone,
            'Joined: ' . $created,
            getStatus($user->status),
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        return [];
    }
}
