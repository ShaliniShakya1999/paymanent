<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusBookingTransaction;
use Illuminate\Http\Request;

class BusBookingAdminController extends Controller
{
    public function sourceCities(Request $request)
    {
        $cities = BusBookingTransaction::select('source_city_id', 'source_city_name')
            ->whereNotNull('source_city_id')->distinct()->orderBy('source_city_name')->paginate(20);
        return view('admin.bus.source_cities', [
            'menu' => 'bus', 'sub_menu' => 'bus_source_cities', 'cities' => $cities,
        ]);
    }

    public function trips(Request $request)
    {
        $query = BusBookingTransaction::with('user:id,first_name,last_name,email');
        if ($request->filled('from')) {
            $query->whereDate('travel_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('travel_date', '<=', $request->to);
        }
        $trips = $query->orderByDesc('travel_date')->paginate(20)->withQueryString();
        return view('admin.bus.trips', [
            'menu' => 'bus', 'sub_menu' => 'bus_trips', 'trips' => $trips,
            'from' => $request->from, 'to' => $request->to,
        ]);
    }

    public function bookings(Request $request)
    {
        $query = BusBookingTransaction::with('user:id,first_name,last_name,email');
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $bookings = $query->orderByDesc('id')->paginate(20)->withQueryString();
        return view('admin.bus.bookings', [
            'menu' => 'bus', 'sub_menu' => 'bus_bookings', 'bookings' => $bookings,
            'from' => $request->from, 'to' => $request->to, 'status' => $request->get('status', 'all'),
        ]);
    }

    public function cancellations(Request $request)
    {
        $query = BusBookingTransaction::with('user:id,first_name,last_name,email')->whereNotNull('cancelled_at');
        if ($request->filled('from')) {
            $query->whereDate('cancelled_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('cancelled_at', '<=', $request->to);
        }
        $cancellations = $query->orderByDesc('cancelled_at')->paginate(20)->withQueryString();
        return view('admin.bus.cancellations', [
            'menu' => 'bus', 'sub_menu' => 'bus_cancellations', 'cancellations' => $cancellations,
            'from' => $request->from, 'to' => $request->to,
        ]);
    }
}
