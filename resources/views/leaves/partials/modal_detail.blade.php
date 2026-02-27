<div class="modal fade" id="leaveDetailModal{{ $leave->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Nama:</strong> {{ $leave->user->fullname ?? 'N/A' }}</p>
                <p><strong>Alasan:</strong> {{ $leave->reason }}</p>

                <hr>

                <p>
                    <strong>Status Saat Ini:</strong>
                    <span class="status-badge {{ $statusConfig['class'] }}">
                        {{ $statusConfig['text'] }}
                    </span>
                </p>

                @if($leave->pic_approved_at)
                <p>
                    <strong>Persetujuan PIC:</strong>
                    Disetujui oleh {{ $leave->picApprover->fullname ?? 'N/A' }}
                    ({{ \Carbon\Carbon::parse($leave->pic_approved_at)->format('d M Y H:i') }})
                </p>
                @endif

                @if($leave->status == 'approved')
                <p>
                    <strong>Persetujuan HO:</strong>
                    Disetujui oleh {{ $leave->hoApprover->fullname ?? 'N/A' }}
                    ({{ \Carbon\Carbon::parse($leave->approved_at)->format('d M Y H:i') }})
                </p>
                @endif
            </div>

            <div class="modal-footer">

                @if (Auth::user()->role == 'Leader Apron' && $leave->status == 'pending Apron')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected by leader">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif

                @if (Auth::user()->role == 'Leader Bge' && $leave->status == 'pending Bge')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected by leader">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif

                @if (Auth::user()->role == 'Head Of Airport Service' && $leave->status == 'pending')
                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected by ho">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>

                <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn btn-success">Setujui</button>
                </form>
                @endif

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
