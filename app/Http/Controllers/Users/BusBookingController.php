<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\BusBookingTransaction;
use App\Services\BusBookingApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusBookingController extends Controller
{
    protected BusBookingApiService $api;

    public function __construct(BusBookingApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        if (!config('bus_booking.enabled')) {
            return redirect()->route('user.dashboard')->with('warning', __('Bus Booking is currently disabled.'));
        }
        $data = [
            'menu' => 'bus_booking',
            'icon' => 'bus-front',
            'content_title' => __('Bus Booking'),
        ];
        return view('user.bus-booking.index', $data);
    }

    public function getSourceCities()
    {
        $result = $this->api->getSourceCities();
        return response()->json($result);
    }

    public function getTrips(Request $request)
    {
        $request->validate([
            'source_id' => 'required|string|max:64',
            'dest_id' => 'required|string|max:64',
            'date' => 'required|date',
        ]);
        $result = $this->api->getAvailableTrips(
            $request->source_id,
            $request->dest_id,
            $request->date
        );
        return response()->json($result);
    }

    public function getTripDetail(Request $request)
    {
        $request->validate(['trip_id' => 'required|string|max:64']);
        $result = $this->api->getTripDetails($request->trip_id);
        return response()->json($result);
    }

    public function getBoardingPoints(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|string|max:64',
            'bpId' => 'required|string|max:64',
        ]);

        $result = $this->api->getBoardingPoints($request->trip_id, $request->bpId);
        return response()->json($result);
    }

    public function blockTicket(Request $request)
    {
        $request->validate([
            'availableTripId' => 'required',
            'boardingPointId' => 'required',
            'inventoryItems' => 'required|array|min:1',
        ]);

        $result = $this->api->blockTicket($request->all());
        $success = !empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200;
        $refid = $result['refid'] ?? $result['reference_id'] ?? ($result['data']['refid'] ?? null);

        return response()->json(array_merge($result, [
            'success' => $success,
            'refid' => $refid,
        ]));
    }

    public function bookTicket(Request $request)
    {
        $request->validate([
            'refid' => 'required|string|max:64',
            'trip_id' => 'nullable|string|max:64',
            'amount' => 'required|numeric|min:0',
            'source_city_id' => 'nullable|string|max:64',
            'source_city_name' => 'nullable|string|max:191',
            'dest_city_id' => 'nullable|string|max:64',
            'dest_city_name' => 'nullable|string|max:191',
            'travel_date' => 'nullable|date',
            'passenger_details' => 'nullable|array',
        ]);

        $referenceId = (string) $request->refid;
        $result = $this->api->bookTicket([
            'refid' => $referenceId,
            'amount' => $request->amount,
        ]);

        $pnr = $result['data']['pnr'] ?? $result['pnr'] ?? null;
        $status = (!empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200) ? 'booked' : 'failed';
        BusBookingTransaction::create([
            'user_id' => Auth::id(),
            'reference_id' => $referenceId,
            'pnr' => $pnr,
            'trip_id' => $request->trip_id,
            'source_city_id' => $request->source_city_id,
            'source_city_name' => $request->source_city_name,
            'dest_city_id' => $request->dest_city_id,
            'dest_city_name' => $request->dest_city_name,
            'travel_date' => $request->travel_date,
            'passenger_details' => $request->passenger_details,
            'amount' => $request->amount,
            'status' => $status,
            'api_response' => $result,
        ]);
        return response()->json(array_merge($result, ['reference_id' => $referenceId]));
    }

    public function checkBooking(Request $request)
    {
        $request->validate(['refid' => 'required|string|max:64']);
        $result = $this->api->checkBookedTicket($request->refid);
        return response()->json($result);
    }

    public function getBooking(Request $request)
    {
        $request->validate(['refid' => 'required|string|max:64']);
        $result = $this->api->getBookedTicket($request->refid);
        return response()->json($result);
    }

    public function myBookings()
    {
        $bookings = BusBookingTransaction::where('user_id', Auth::id())
            ->whereIn('status', ['booked', 'cancelled'])
            ->orderByDesc('created_at')
            ->paginate(10);
        $data = ['menu' => 'bus_booking', 'content_title' => __('My Bus Bookings'), 'bookings' => $bookings];
        return view('user.bus-booking.my-bookings', $data);
    }

    public function getCancellationData(Request $request)
    {
        $request->validate(['refid' => 'required|string|max:64']);
        $result = $this->api->getCancellationData($request->refid);
        return response()->json($result);
    }

    public function cancelTicket(Request $request)
    {
        $request->validate([
            'refid' => 'required|string|max:64',
            'seatsToCancel' => 'required|array|min:1',
        ]);

        $booking = BusBookingTransaction::where('user_id', Auth::id())
            ->where('reference_id', $request->refid)
            ->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => __('Booking not found.')], 404);
        }

        $result = $this->api->cancelTicket($request->refid, $request->seatsToCancel);

        $success = !empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200;
        if ($success) {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_ref' => $result['data']['cancellation_id'] ?? $result['reference_id'] ?? $request->refid,
                'api_response' => $result,
            ]);
        }

        return response()->json(array_merge($result, ['success' => $success]));
    }
}
