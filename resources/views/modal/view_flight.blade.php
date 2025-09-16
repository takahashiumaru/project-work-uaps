@if(isset($flight))
<div class="modal fade" id="viewFlightModal{{ $flight->id }}" tabindex="-1" aria-labelledby="viewFlightModalLabel{{ $flight->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFlightModalLabel{{ $flight->id }}">Flight Detail - {{ $flight->flight_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Airline:</strong> {{ $flight->airline }}</p>
                <p><strong>Registration:</strong> {{ $flight->registasi }}</p>
                <p><strong>Type:</strong> {{ $flight->type }}</p>
                <p><strong>Arrival:</strong> {{ $flight->arrival }}</p>
                <hr>
                <h6>Pengerjaan Flight</h6>
                <ol type="1" style="margin-left: 1rem;">
                    @forelse($flight->details as $detail)
                    <li>
                        NIP: {{ $detail->schedule->user->id ?? 'N/A' }} |
                        Nama: {{ $detail->schedule->user->fullname ?? 'N/A' }} |
                        Qantas: {{ $detail->schedule->user->is_qantas == 1 ? 'Iya' : 'Tidak' }}
                    </li>
                    @empty
                    <li>No flight details available.</li>
                    @endforelse
                </ol>
            </div>
        </div>
    </div>
</div>
@endif
