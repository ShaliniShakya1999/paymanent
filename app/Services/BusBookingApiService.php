<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusBookingApiService
{
    protected string $baseUrl;
    protected string $token;
    protected string $authorisedKey;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl   = rtrim(config('bus_booking.base_url', ''), '/');
        $this->token    = config('bus_booking.token', '');
        $this->authorisedKey = config('bus_booking.authorised_key', '');
        $this->timeout  = (int) config('bus_booking.timeout', 45);
        $this->verifySsl = (bool) config('bus_booking.verify_ssl', false);
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
            'Authorisedkey' => $this->authorisedKey,
            'Token'        => $this->token,
        ];
    }

    protected function get(string $endpoint, array $query = []): array
    {
        if (!$this->baseUrl) {
            return ['success' => false, 'message' => __('Bus Booking API is not configured.'), 'data' => []];
        }
        $url = $this->baseUrl . $endpoint . ($query ? '?' . http_build_query($query) : '');
        $response = Http::timeout($this->timeout)
            ->withOptions(['verify' => $this->verifySsl])
            ->withHeaders($this->getHeaders())
            ->get($url);
        $data = $response->json();
        if ($response->failed()) {
            Log::warning('Bus Booking API request failed', ['url' => $url, 'status' => $response->status()]);
        }
        return is_array($data) ? $data : [];
    }

    protected function post(string $endpoint, array $body = []): array
    {
        if (!$this->baseUrl) {
            return ['success' => false, 'message' => __('Bus Booking API is not configured.'), 'data' => []];
        }
        $url = $this->baseUrl . $endpoint;
        $response = Http::timeout($this->timeout)
            ->withOptions(['verify' => $this->verifySsl])
            ->withHeaders($this->getHeaders())
            ->post($url, $body);
        $data = $response->json();
        if ($response->failed()) {
            Log::warning('Bus Booking API request failed', ['url' => $url, 'status' => $response->status()]);
        }
        return is_array($data) ? $data : [];
    }

    public function getSourceCities(): array
    {
        $result = $this->post('/api/v1/service/bus/ticket/source', []);
        $list = $result['data']['cities'] ?? $result['cities'] ?? $result['data'] ?? [];
        $success = !empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200 || !empty($list);

        return [
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('Source cities fetched successfully.') : __('Source cities fetch failed.')),
            'cities' => is_array($list) ? $list : [],
            'raw' => $result,
        ];
    }

    public function getAvailableTrips(string $sourceId, string $destId, string $date): array
    {
        $result = $this->post('/api/v1/service/bus/ticket/availabletrips', [
            'source_id'       => $sourceId,
            'destination_id'  => $destId,
            'date_of_journey' => $date,
        ]);
        $list = $result['data']['trips'] ?? $result['trips'] ?? $result['data'] ?? [];
        $success = !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200 || !empty($list);

        return [
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('Trips fetched successfully.') : __('No trips found.')),
            'trips'   => is_array($list) ? $list : [],
            'raw'     => $result,
        ];
    }

    public function getTripDetails(string $tripId): array
    {
        $result = $this->post('/api/v1/service/bus/ticket/tripdetails', ['trip_id' => $tripId]);
        $success = !empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200;

        return [
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('Trip details fetched successfully.') : __('Trip details fetch failed.')),
            'data' => $result['data'] ?? $result,
            'raw' => $result,
        ];
    }

    public function getBoardingPoints(string $tripId, ?string $bpId = null): array
    {
        if ($bpId === null || $bpId === '') {
            return [
                'success' => false,
                'message' => __('Boarding point ID is required.'),
                'data' => [],
            ];
        }

        $result = $this->post('/api/v1/service/bus/ticket/boardingPoint', [
            'bpId' => $bpId,
            'trip_id' => $tripId,
        ]);

        $success = !empty($result['success']) || !empty($result['status']) || (int) ($result['statuscode'] ?? $result['status_code'] ?? 0) === 200;

        return [
            'success' => $success,
            'message' => $result['message'] ?? ($success ? __('Boarding point fetched successfully.') : __('Boarding point fetch failed.')),
            'data' => $result['data'] ?? $result,
            'raw' => $result,
        ];
    }

    public function blockTicket(array $params): array
    {
        return $this->post('/api/v1/service/bus/ticket/blockticket', [
            'availableTripId' => $params['availableTripId'] ?? null,
            'boardingPointId' => $params['boardingPointId'] ?? null,
            'inventoryItems'  => (object) ($params['inventoryItems'] ?? []),
        ]);
    }

    public function bookTicket(array $params): array
    {
        return $this->post('/api/v1/service/bus/ticket/bookticket', [
            'refid' => $params['refid'] ?? null,
            'amount' => $params['amount'] ?? 0,
        ]);
    }

    public function checkBookedTicket(string $referenceId): array
    {
        return $this->post('/api/v1/service/bus/ticket/check_booked_ticket', ['refid' => $referenceId]);
    }

    public function getBookedTicket(string $referenceId): array
    {
        return $this->post('/api/v1/service/bus/ticket/get_ticket', ['refid' => $referenceId]);
    }

    public function getCancellationData(string $referenceId): array
    {
        return $this->post('/api/v1/service/bus/ticket/get_cancellation_data', ['refid' => $referenceId]);
    }

    public function cancelTicket(string $referenceId, array $seatsToCancel = []): array
    {
        $payload = [
            'refid' => $referenceId,
            'seatsToCancel' => (object) $seatsToCancel,
        ];

        return $this->post('/api/v1/service/bus/ticket/cancel_ticket', $payload);
    }
}
