<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusBookingTransaction extends Model
{
    protected $table = 'bus_booking_transactions';

    protected $fillable = [
        'user_id',
        'reference_id',
        'pnr',
        'trip_id',
        'source_city_id',
        'source_city_name',
        'dest_city_id',
        'dest_city_name',
        'travel_date',
        'passenger_details',
        'amount',
        'status',
        'api_response',
        'cancelled_at',
        'cancellation_ref',
    ];

    protected $casts = [
        'amount'            => 'decimal:2',
        'passenger_details' => 'array',
        'api_response'      => 'array',
        'travel_date'       => 'date',
        'cancelled_at'      => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
