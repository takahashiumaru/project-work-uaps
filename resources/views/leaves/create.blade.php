@extends('layout.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Apply Leave /</span> Formulir Pengajuan Izin/Cuti
</h4>

<div class="row">
    {{-- Mengganti col-md-8 col-md-offset-2 menjadi col-lg-8, agar layout lebih responsif --}}
    <div class="col-lg-8 mx-auto"> 
        <div class="card mb-4">
            <h5 class="card-header">Formulir Pengajuan Izin/Cuti</h5>
            
            <div class="card-body">
                <p><strong>Sisa Cuti Tahunan Anda:</strong> {{ $leaveBalance ?? 0 }} hari</p>
                <hr>

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error Pengajuan:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Route dan method tetap dipertahankan --}}
                <form method="POST" action="{{ route('leaves.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="leave_type" class="form-label">Jenis Pengajuan</label>
                        {{-- Dropdown baru yang lebih lengkap --}}
                        <select name="leave_type" id="leave_type" class="form-select @error('leave_type') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Cuti --</option>
                            <option value="Cuti Tahunan" {{ old('leave_type') == 'Cuti Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                            <option value="Cuti Sakit" {{ old('leave_type') == 'Cuti Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                            <option value="Izin" {{ old('leave_type') == 'Izin' ? 'selected' : '' }}>Izin (Izin mendadak, izin ke dokter, dll.)</option>
                            <option value="Cuti Melahirkan/Keguguran" {{ old('leave_type') == 'Cuti Melahirkan/Keguguran' ? 'selected' : '' }}>Cuti Melahirkan/Keguguran</option>
                            <option value="Cuti Menikah" {{ old('leave_type') == 'Cuti Menikah' ? 'selected' : '' }}>Cuti Menikah</option>
                            <option value="Cuti Duka" {{ old('leave_type') == 'Cuti Duka' ? 'selected' : '' }}>Cuti Duka (Meninggal Dunia)</option>
                            <option value="Cuti Lainnya" {{ old('leave_type') == 'Cuti Lainnya' ? 'selected' : '' }}>Cuti Lainnya (Sertakan keterangan)</option>
                        </select>
                        @error('leave_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Tanggal Berakhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Durasi Pengajuan:</label>
                        <div id="total_days_display"><strong>0 Hari</strong></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan/Keterangan</label>
                        <textarea name="reason" id="reason" rows="4" class="form-control @error('reason') is-invalid @enderror" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachment_file" class="form-label">Lampiran (Opsional, max 2MB)</label>
                        <input type="file" name="attachment_file" id="attachment_file" class="form-control @error('attachment_file') is-invalid @enderror">
                        <small class="form-text text-muted">Contoh: Surat dokter, surat keterangan.</small>
                        @error('attachment_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Tombol aksi, penyesuaian style --}}
                    <button type="submit" class="btn btn-primary mt-3">Kirim Pengajuan</button>
                    {{-- Mengubah btn-default menjadi btn-secondary --}}
                    <a href="{{ route('leaves.pengajuan') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Script perhitungan hari cuti dipindahkan ke section scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const totalDaysDisplay = document.getElementById('total_days_display');

    function calculateDays() {
        if (!startDateInput.value || !endDateInput.value) {
            totalDaysDisplay.innerHTML = '<strong>0 Hari</strong>';
            return;
        }

        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate >= startDate) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDaysDisplay.innerHTML = `<strong>${diffDays} Hari</strong>`;
        } else {
            totalDaysDisplay.innerHTML = '<strong class="text-danger">Tanggal tidak valid</strong>';
        }
    }
    startDateInput.addEventListener('change', calculateDays);
    endDateInput.addEventListener('change', calculateDays);
    calculateDays(); // Hitung saat halaman dimuat
});
</script>
@endsection