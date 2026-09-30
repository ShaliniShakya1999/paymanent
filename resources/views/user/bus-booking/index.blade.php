@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="busBookingIndex">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Bus Booking') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4">{{ __('Search and book bus tickets') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ $content_title ?? __('Bus Booking') }}</p>
    @include('user.common.alert')

    <div class="mt-28" style="max-width: 980px; margin: 0 auto;">
        <div class="row">
            <div class="col-md-12">
                <div class="p-0">
                    <div class="clearfix">
                        <div class="pull-left">
                            <p class="mb-1 f-18 gilroy-Semibold text-dark">{{ __('Find Your Bus') }}</p>
                            <p class="mb-0 text-muted f-13">{{ __('Choose source, destination and travel date to see available buses.') }}</p>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('user.bus_booking.my_bookings') }}" class="btn btn-default">{{ __('My Bookings') }}</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Source City') }}</label>
                            <select class="form-control select2" id="bus_source_id" style="display:block;visibility:visible;width:100%;min-height:48px;">
                                <option value="">{{ __('Select source') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Destination City') }}</label>
                            <select class="form-control select2" id="bus_dest_id" style="display:block;visibility:visible;width:100%;min-height:48px;">
                                <option value="">{{ __('Select destination') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-20">
                            <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Travel Date') }}</label>
                            <input type="date" class="form-control input-form-control apply-bg" id="bus_date" style="min-height:48px;">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary px-4 py-2" id="bus_search_btn">{{ __('Search Buses') }}</button>
                        <button type="button" class="btn btn-default px-4 py-2" id="bus_reset_btn" style="margin-left: 8px;">{{ __('Reset') }}</button>
                    </div>

                    <div id="bus_search_message" class="mt-3 d-none p-3 border rounded"></div>
                </div>
            </div>
        </div>

        <div id="bus_trips_list" class="mt-20"></div>

        <!-- Selected trip: Detail + Boarding + Block + Book -->
        <div id="bus_trip_booking_panel" class="mt-20 d-none">
            <div class="p-0">
                <p class="mb-1 f-18 gilroy-Semibold text-dark">{{ __('Trip Details & Booking') }}</p>
                <p class="mb-0 text-muted f-13">{{ __('Review selected trip and complete the booking details.') }}</p>
            </div>
            <div class="mt-3">
                <div id="bus_trip_detail_text" class="mb-3 small text-muted"></div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Boarding Point ID') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_boarding_point_id" placeholder="{{ __('Enter boarding point ID') }}">
                        <small class="text-muted d-block mt-2">{{ __('Use the provider boarding point ID for the selected trip.') }}</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Seat Name') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_seat_ids" placeholder="{{ __('e.g. A15') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Passenger Name') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_passenger_name" placeholder="{{ __('Full name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Passenger Age') }}</label>
                        <input type="number" class="form-control input-form-control apply-bg" id="bus_passenger_age" placeholder="25" min="1" max="120">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Mobile Number') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_passenger_mobile" placeholder="{{ __('10 digit mobile') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Email') }}</label>
                        <input type="email" class="form-control input-form-control apply-bg" id="bus_passenger_email" placeholder="xyz@gmail.com">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Title') }}</label>
                        <select class="form-control input-form-control apply-bg" id="bus_passenger_title">
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Gender') }}</label>
                        <select class="form-control input-form-control apply-bg" id="bus_passenger_gender">
                            <option value="MALE">{{ __('Male') }}</option>
                            <option value="FEMALE">{{ __('Female') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('ID Type') }}</label>
                        <select class="form-control input-form-control apply-bg" id="bus_passenger_id_type">
                            <option value="Pancard">Pancard</option>
                            <option value="Aadhaar">Aadhaar</option>
                            <option value="DrivingLicence">Driving Licence</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('ID Number') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_passenger_id_number" placeholder="{{ __('Document number') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="gilroy-medium text-gray-100 mb-2 f-15">{{ __('Address') }}</label>
                        <input type="text" class="form-control input-form-control apply-bg" id="bus_passenger_address" placeholder="{{ __('Passenger address') }}">
                    </div>
                </div>
                <div class="mb-3 d-none p-3 border rounded bg-light" id="bus_block_info">
                    <span class="text-success" id="bus_block_msg"></span>
                    <span class="ms-2 countdown small" id="bus_block_expiry"></span>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-primary px-4 py-2" id="bus_block_btn">{{ __('Block Ticket') }}</button>
                    <button type="button" class="btn btn-success d-none px-4 py-2" id="bus_book_btn" style="margin-left: 8px;">{{ __('Pay & Book') }}</button>
                </div>
                <div id="bus_book_result" class="mt-3 d-none p-3 border rounded"></div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var base = '{{ url("/") }}';
    var token = '{{ csrf_token() }}';
    var sourceCitiesUrl = '{{ route("user.bus_booking.source_cities") }}';
    var tripsUrl = '{{ route("user.bus_booking.trips") }}';
    var tripDetailUrl = '{{ route("user.bus_booking.trip_detail") }}';
    var boardingUrl = '{{ route("user.bus_booking.boarding_points") }}';
    var blockUrl = '{{ route("user.bus_booking.block") }}';
    var bookUrl = '{{ route("user.bus_booking.book") }}';

    if (window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) {
        window.jQuery('#bus_source_id').select2({ width: '100%' });
        window.jQuery('#bus_dest_id').select2({ width: '100%' });
    }

    var currentTrip = null;
    var currentSourceId = '', currentDestId = '', currentDate = '';
    var blockId = null;

    function showSearchMessage(success, message) {
        var el = document.getElementById('bus_search_message');
        el.classList.remove('d-none');
        el.className = 'mt-3 p-3 border rounded ' + (success ? 'border-success text-success' : 'border-danger text-danger');
        el.textContent = message || '';
    }

    function showBookResult(success, html) {
        var el = document.getElementById('bus_book_result');
        el.classList.remove('d-none');
        el.className = 'mt-3 p-3 border rounded ' + (success ? 'border-success' : 'border-danger');
        el.innerHTML = html;
    }

    function postJson(url, body, done) {
        var payload = Object.assign({ _token: token }, body || {});
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }, body: JSON.stringify(payload) })
            .then(function(r) { return r.json(); })
            .then(done)
            .catch(function() { if (done) done({ success: false, message: 'Request failed.' }); });
    }

    document.getElementById('bus_reset_btn').addEventListener('click', function() {
        document.getElementById('bus_source_id').value = '';
        document.getElementById('bus_dest_id').value = '';
        document.getElementById('bus_date').value = '';
        document.getElementById('bus_trips_list').innerHTML = '';
        document.getElementById('bus_trip_booking_panel').classList.add('d-none');
        document.getElementById('bus_search_message').classList.add('d-none');
    });

    // Get Source Cities (POST)
    postJson(sourceCitiesUrl, {}, function(res) {
        var cities = res.cities || [];
        var sel1 = document.getElementById('bus_source_id');
        var sel2 = document.getElementById('bus_dest_id');
        cities.forEach(function(c) {
            var id = c.id || c.city_id || c.code;
            var name = c.name || c.city_name || id;
            sel1.innerHTML += '<option value="' + id + '">' + name + '</option>';
            sel2.innerHTML += '<option value="' + id + '">' + name + '</option>';
        });
        showSearchMessage(true, '{{ __("Source and destination cities loaded.") }}');
    });

    document.getElementById('bus_search_btn').addEventListener('click', function() {
        var src = document.getElementById('bus_source_id').value;
        var dest = document.getElementById('bus_dest_id').value;
        var date = document.getElementById('bus_date').value;
        if (!src || !dest || !date) {
            showSearchMessage(false, '{{ __("Please select source, destination and date.") }}');
            return;
        }
        currentSourceId = src; currentDestId = dest; currentDate = date;
        this.disabled = true;
        postJson(tripsUrl, { source_id: src, dest_id: dest, date: date }, function(res) {
            document.getElementById('bus_search_btn').disabled = false;
            var list = document.getElementById('bus_trips_list');
            var trips = res.trips || [];
            list.innerHTML = '';
            if (!trips.length) {
                showSearchMessage(false, res.message || '{{ __("No trips found.") }}');
                list.innerHTML = '<div class="border rounded p-4 text-muted">{{ __("No trips found.") }}</div>';
                return;
            }
            showSearchMessage(true, trips.length + ' {{ __("trips found.") }}');
            list.innerHTML = '<p class="f-15 mb-3">' + trips.length + ' {{ __("trips found.") }}</p>';
            window._busTripsList = trips;
            trips.forEach(function(t, idx) {
                var tid = t.id || t.trip_id || t.tripId || '';
                var name = t.bus_name || t.name || t.operator_name || tid;
                var dep = t.departure_time || t.departureTime || t.start_time || '-';
                var fare = t.fare || t.amount || t.price || '-';
                var card = document.createElement('div');
                card.className = 'border rounded p-3 mb-3';
                card.innerHTML = '<div class="clearfix"><div class="pull-left"><strong style="display:block; margin-bottom:6px;">' + (name + '').replace(/</g, '&lt;') + '</strong><span class="text-muted" style="margin-right:12px;">{{ __("Departure") }}: ' + (dep + '').replace(/</g, '&lt;') + '</span><span class="text-muted">{{ __("Fare") }}: ₹' + (fare + '').replace(/</g, '&lt;') + '</span></div><div class="pull-right" style="margin-top:6px;"><button type="button" class="btn btn-primary bus_select_trip" data-idx="' + idx + '">{{ __("Select Bus") }}</button></div></div>';
                list.appendChild(card);
            });
            list.querySelectorAll('.bus_select_trip').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var idx = parseInt(this.getAttribute('data-idx'), 10);
                    currentTrip = window._busTripsList && window._busTripsList[idx] ? window._busTripsList[idx] : null;
                    blockId = null;
                    document.getElementById('bus_book_btn').classList.add('d-none');
                    document.getElementById('bus_block_info').classList.add('d-none');
                    document.getElementById('bus_book_result').classList.add('d-none');
                    document.getElementById('bus_trip_booking_panel').classList.remove('d-none');
                    var tid = currentTrip.id || currentTrip.trip_id || currentTrip.tripId || '';
                    document.getElementById('bus_trip_detail_text').textContent = 'Loading...';
                    postJson(tripDetailUrl, { trip_id: tid }, function(detailRes) {
                        var d = detailRes.data || detailRes;
                        var txt = (d.bus_name || d.name || '') + ' ' + (d.departure_time || '') + ' ' + (d.fare ? '₹' + d.fare : '');
                        document.getElementById('bus_trip_detail_text').textContent = txt || 'Trip: ' + tid;
                    });
                });
            });
        });
    });

    document.getElementById('bus_block_btn').addEventListener('click', function() {
        if (!currentTrip) return;
        var blockBtn = this;
        var tid = currentTrip.id || currentTrip.trip_id || currentTrip.tripId || '';
        var boardingPointId = document.getElementById('bus_boarding_point_id').value;
        var seatName = document.getElementById('bus_seat_ids').value.trim();
        var name = document.getElementById('bus_passenger_name').value;
        var age = document.getElementById('bus_passenger_age').value;
        var mobile = document.getElementById('bus_passenger_mobile').value.trim();
        var email = document.getElementById('bus_passenger_email').value.trim();
        var title = document.getElementById('bus_passenger_title').value;
        var gender = document.getElementById('bus_passenger_gender').value;
        var idType = document.getElementById('bus_passenger_id_type').value;
        var idNumber = document.getElementById('bus_passenger_id_number').value.trim();
        var address = document.getElementById('bus_passenger_address').value.trim();
        var fare = parseFloat(currentTrip.fare || currentTrip.amount || currentTrip.price || 0) || 0;
        var serviceTax = parseFloat(currentTrip.serviceTax || currentTrip.service_tax || 0) || 0;
        var operatorServiceCharge = parseFloat(currentTrip.operatorServiceCharge || currentTrip.operator_service_charge || 0) || 0;

        if (!boardingPointId || !seatName || !name || !mobile || !email || !idNumber || !address) {
            showBookResult(false, '<span class="text-danger">{{ __("Please fill boarding point, seat, passenger, mobile, email, ID number and address.") }}</span>');
            return;
        }

        blockBtn.disabled = true;

        postJson(boardingUrl, { trip_id: tid, bpId: boardingPointId }, function(boardingRes) {
            var boardingSuccess = boardingRes && (boardingRes.success || boardingRes.status || boardingRes.data);
            if (!boardingSuccess) {
                blockBtn.disabled = false;
                showBookResult(false, '<span class="text-danger">' + ((boardingRes && boardingRes.message) || '{{ __("Invalid boarding point.") }}') + '</span>');
                return;
            }

            postJson(blockUrl, {
                availableTripId: tid,
                boardingPointId: boardingPointId,
                inventoryItems: {
                    0: {
                        seatName: seatName,
                        fare: fare,
                        serviceTax: serviceTax,
                        operatorServiceCharge: operatorServiceCharge,
                        ladiesSeat: 'false',
                        passenger: {
                            name: name,
                            mobile: mobile,
                            title: title,
                            email: email,
                            age: age || null,
                            gender: gender,
                            address: address,
                            idType: idType,
                            idNumber: idNumber,
                            primary: '1'
                        }
                    }
                }
            }, function(res) {
                blockBtn.disabled = false;
                var returnedRefid = res.refid || (res.data && (res.data.refid || res.data.block_id)) || res.block_id;
                if (res.success && returnedRefid) {
                    blockId = returnedRefid;
                    document.getElementById('bus_block_msg').textContent = '{{ __("Blocked. Ref ID:") }} ' + blockId;
                    document.getElementById('bus_block_info').classList.remove('d-none');
                    document.getElementById('bus_book_btn').classList.remove('d-none');
                } else {
                    document.getElementById('bus_block_msg').textContent = res.message || '{{ __("Block failed.") }}';
                    document.getElementById('bus_block_info').classList.remove('d-none');
                }
            });
        });
    });

    document.getElementById('bus_book_btn').addEventListener('click', function() {
        if (!blockId || !currentTrip) return;
        var tid = currentTrip.id || currentTrip.trip_id || currentTrip.tripId || '';
        var amount = currentTrip.fare || currentTrip.amount || currentTrip.price || 0;
        var name = document.getElementById('bus_passenger_name').value;
        var age = document.getElementById('bus_passenger_age').value;
        this.disabled = true;
        var srcOpt = document.getElementById('bus_source_id').selectedOptions[0];
        var destOpt = document.getElementById('bus_dest_id').selectedOptions[0];
        postJson(bookUrl, {
            refid: blockId,
            trip_id: tid,
            amount: amount,
            source_city_id: currentSourceId,
            source_city_name: srcOpt ? srcOpt.textContent : '',
            dest_city_id: currentDestId,
            dest_city_name: destOpt ? destOpt.textContent : '',
            travel_date: currentDate,
            passenger_details: [{ name: name, age: age || null }]
        }, function(res) {
            document.getElementById('bus_book_btn').disabled = false;
            if (res.success) {
                var pnr = (res.data && res.data.pnr) || res.pnr || '';
                showBookResult(true, '<span class="text-success">{{ __("Booked successfully.") }}</span> ' + (pnr ? '<br>{{ __("PNR:") }} ' + pnr + ' <a href="{{ route("user.bus_booking.my_bookings") }}">{{ __("My Bookings") }}</a>' : ''));
            } else {
                showBookResult(false, '<span class="text-danger">' + (res.message || '{{ __("Booking failed.") }}') + '</span>');
            }
        });
    });
});
</script>
@endsection
