{{-- resources/views/leaves/partials/modal_detail.blade.php --}}
<div class="modal fade" id="leaveDetailModal{{ $leave->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Pengajuan</h4>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> {{ $leave->user->fullname ?? 'N/A' }}</p>
                <p><strong>Alasan:</strong> {{ $leave->reason }}</p>
                {{-- Detail approval --}}
                <hr>
                <p><strong>Status Saat Ini:</strong> <span class="status-badge {{ $statusConfig['class'] }}">{{ $statusConfig['text'] }}</span></p>
                @if($leave->pic_approved_at)
                <p><strong>Persetujuan PIC:</strong> Disetujui oleh {{ $leave->picApprover->fullname ?? 'N/A' }} ({{ \Carbon\Carbon::parse($leave->pic_approved_at)->format('d M Y H:i') }})</p>
                @endif
                @if($leave->status == 'approved')
                <p><strong>Persetujuan HO:</strong> Disetujui oleh {{ $leave->hoApprover->fullname ?? 'N/A' }} ({{ \Carbon\Carbon::parse($leave->approved_at)->format('d M Y H:i') }})</p>
                @endif
            </div>
            <div class="modal-footer">
                @if (Auth::user()->role == 'SPV' && $leave->status == 'pending Apron')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected_by_pic">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif

                @if (Auth::user()->role == 'SPV' && $leave->status == 'pending Bge')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected_by_ho">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif

                @if (Auth::user()->station == 'Ho' && $leave->status == 'pending')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected_by_ho">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
