<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCommission;
use Illuminate\Http\Request;
use Validator;

class ServiceCommissionController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'menu' => 'settings',
            'settings_menu' => 'service_commission',
            'commissions' => ServiceCommission::orderBy('service_slug')->get(),
        ];

        if ($request->isMethod('post')) {
            $rules = [
                'commission_percent.*' => 'nullable|numeric|min:0|max:100',
                'commission_fixed.*' => 'nullable|numeric|min:0',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $percent = $request->commission_percent ?? [];
            $fixed = $request->commission_fixed ?? [];
            $active = $request->is_active ?? [];

            foreach (ServiceCommission::all() as $row) {
                $slug = $row->service_slug;
                $row->commission_percent = $percent[$slug] ?? 0;
                $row->commission_fixed = $fixed[$slug] ?? 0;
                $row->is_active = isset($active[$slug]);
                $row->save();
            }

            (new \App\Http\Helpers\Common())->one_time_message('success', __('Service commissions saved successfully.'));
            return redirect(url(config('adminPrefix') . '/settings/service-commission'));
        }

        return view('admin.settings.service_commission', $data);
    }
}
