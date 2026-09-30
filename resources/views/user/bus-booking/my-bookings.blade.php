@extends('user.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase">{{ __('My Bus Bookings') }}</p>
    <p class="mb-0 text-muted small">{{ __('Check status, view ticket, get cancellation charges, or cancel.') }}</p>
    @include('user.common.alert')

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('PNR') }}</th>
                    <th>{{ __('Route') }}</th>
                    <th>{{ __('Travel Date') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>{{ $b->pnr ?? $b->reference_id }}</td>
                    <td>{{ $b->source_city_name }} → {{ $b->dest_city_name }}</td>
                    <td>{{ $b->travel_date ? \Carbon\Carbon::parse($b->travel_date)->format('d M Y') : '-' }}</td>
                    <td>{{ number_format($b->amount ?? 0, 2) }}</td>
                    <td><span class="badge bg-{{ $b->status === 'booked' ? 'success' : ($b->status === 'cancelled' ? 'secondary' : 'warning') }}">{{ $b->status }}</span></td>
                    <td>{{ $b->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if(($b->pnr ?? $b->reference_id))
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary bus_check_btn" data-pnr="{{ $b->pnr ?? $b->reference_id }}" data-refid="{{ $b->reference_id }}" title="{{ __('Check Status') }}">{{ __('Check') }}</button>
                            <button type="button" class="btn btn-outline-info bus_get_btn" data-pnr="{{ $b->pnr ?? $b->reference_id }}" data-refid="{{ $b->reference_id }}" title="{{ __('Get Booked Ticket') }}">{{ __('Ticket') }}</button>
                            <button type="button" class="btn btn-outline-warning bus_cancel_data_btn" data-pnr="{{ $b->pnr ?? $b->reference_id }}" data-refid="{{ $b->reference_id }}" title="{{ __('Get Cancellation Data') }}">{{ __('Cancel Info') }}</button>
                            @if($b->status === 'booked')
                            <button type="button" class="btn btn-outline-danger bus_cancel_btn" data-pnr="{{ $b->pnr ?? $b->reference_id }}" data-refid="{{ $b->reference_id }}" title="{{ __('Ticket Cancellation') }}">{{ __('Cancel') }}</button>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">{{ __('No bookings yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}

    <div id="bus_modal_result" class="mt-4 p-3 border rounded d-none"></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var token = '{{ csrf_token() }}';
    var checkUrl = '{{ route("user.bus_booking.check_booking") }}';
    var getUrl = '{{ route("user.bus_booking.get_booking") }}';
    var cancelDataUrl = '{{ route("user.bus_booking.cancellation_data") }}';
    var cancelUrl = '{{ route("user.bus_booking.cancel") }}';

    function postJson(url, body, done) {
        var payload = Object.assign({ _token: token }, body || {});
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }, body: JSON.stringify(payload) })
            .then(function(r) { return r.json(); })
            .then(done)
            .catch(function() { if (done) done({ success: false, message: 'Request failed.' }); });
    }

    function showResult(title, data) {
        var el = document.getElementById('bus_modal_result');
        el.classList.remove('d-none');
        el.innerHTML = '<strong>' + title + '</strong><pre class="mb-0 mt-2 small">' + (typeof data === 'string' ? data : JSON.stringify(data, null, 2)) + '</pre>';
    }

    document.querySelectorAll('.bus_check_btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pnr = this.getAttribute('data-pnr');
            var refid = this.getAttribute('data-refid');
            postJson(checkUrl, { refid: refid }, function(res) { showResult('{{ __("Check Booked Ticket") }} (PNR: ' + pnr + ')', res); });
        });
    });
    document.querySelectorAll('.bus_get_btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pnr = this.getAttribute('data-pnr');
            var refid = this.getAttribute('data-refid');
            postJson(getUrl, { refid: refid }, function(res) { showResult('{{ __("Get Booked Ticket") }} (PNR: ' + pnr + ')', res); });
        });
    });
    document.querySelectorAll('.bus_cancel_data_btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pnr = this.getAttribute('data-pnr');
            var refid = this.getAttribute('data-refid');
            postJson(cancelDataUrl, { refid: refid }, function(res) { showResult('{{ __("Get Cancellation Data") }} (PNR: ' + pnr + ')', res); });
        });
    });
    document.querySelectorAll('.bus_cancel_btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pnr = this.getAttribute('data-pnr');
            var refid = this.getAttribute('data-refid');
            var seatsInput = prompt('{{ __("Enter seat numbers to cancel, separated by commas.") }}', '');
            if (seatsInput === null) return;
            var seats = seatsInput.split(',').map(function(item) {
                return item.trim();
            }).filter(Boolean);
            if (!seats.length) {
                showResult('{{ __("Ticket Cancellation") }}', { success: false, message: '{{ __("Please enter at least one seat number.") }}' });
                return;
            }
            var seatsToCancel = {};
            seats.forEach(function(seat, index) {
                seatsToCancel[index] = seat;
            });
            if (!confirm('{{ __("Cancel this ticket?") }}')) return;
            postJson(cancelUrl, { refid: refid, seatsToCancel: seatsToCancel }, function(res) {
                showResult('{{ __("Ticket Cancellation") }} (PNR: ' + pnr + ')', res);
                if (res.success) setTimeout(function() { location.reload(); }, 1500);
            });
        });
    });
});
</script>
@endsection
