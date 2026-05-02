@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Blacklist</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Daftar karyawan yang telah di-blacklist dari perusahaan.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIK / ID</th>
                                <th>Nama</th>
                                <th>Alasan Blacklist</th>
                                <th>Station</th>
                                <th>Di Blacklist oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blacklists as $blacklist)
                            <tr>
                                <td><strong>{{ $blacklist->nik }}</strong></td>
                                <td>{{ $blacklist->fullname }}</td>
                                <td>{{ $blacklist->reason }}</td>
                                <td><span class="badge bg-label-info">{{ $blacklist->station }}</span></td>
                                <td>{{ $blacklist->banned_by }}</td>
                                <td>{{ \Carbon\Carbon::parse($blacklist->created_at)->translatedFormat('d F Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bx bx-check-shield d-block"></i>
                                        <p>Tidak ada data blacklist.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="dt-pagination-wrapper">
                    {{ $blacklists->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT & BAN --}}
@if(Auth::user()->role == 'Admin')
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Data Staff (Bulk)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning text-small" style="font-size: 0.85rem;">
                        <i class="bx bx-info-circle me-1"></i>
                        Pastikan file CSV sesuai format. Password user baru otomatis: <b>password123</b>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <label class="form-label fw-bold">Langkah 1: Download Template</label>
                        <a href="{{ route('staff.template') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="bx bx-download me-1"></i> Download Template CSV
                        </a>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold">Langkah 2: Upload File CSV</label>
                        <input type="file" name="file" class="form-control" required accept=".csv, .xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="banModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #fef2f2; border-bottom: 1px solid #fecaca;">
                <h5 class="modal-title" style="color: #dc2626;">
                    <i class="bx bx-error-alt me-2"></i> Blacklist Staff (PHK & Ban)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Tindakan ini akan <b>mematikan akun</b> staff dan mencatat namanya ke dalam daftar hitam perusahaan selamanya.
                    </div>
                    <input type="hidden" name="user_id" id="ban_user_id">
                    <div class="mb-3">
                        <label class="form-label">Nama Staff</label>
                        <input type="text" class="form-control" id="ban_user_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Pelanggaran (Wajib Diisi)</label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Contoh: Terbukti mencuri aset perusahaan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background-color:#dc2626; border-color:#dc2626; color:#fff;">Konfirmasi Blacklist</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openBanModal(id, name) {
        document.getElementById('ban_user_id').value = id;
        document.getElementById('ban_user_name').value = name;
        var myModal = new bootstrap.Modal(document.getElementById('banModal'));
        myModal.show();
    }
</script>
@endif

@endsection
