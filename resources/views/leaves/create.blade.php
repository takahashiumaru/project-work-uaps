@extends('app')

@section('title', 'Form Pengajuan Cuti')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Formulir Pengajuan Izin/Cuti</div>

                <div class="panel-body">
                    <p><strong>Sisa Cuti Tahunan Anda:</strong> {{ $leaveBalance ?? 0 }} hari</p>
                    <hr>

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('leaves.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="leave_type">Jenis Pengajuan</label>
                            {{-- Dropdown baru yang lebih lengkap --}}
                            <select name="leave_type" id="leave_type" class="form-control @error('leave_type') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan" {{ old('leave_type') == 'Cuti Tahunan' ? 'selected' : '' }}>Annual Leave (Cuti Tahunan)</option>
                                <option value="Cuti Sakit" {{ old('leave_type') == 'Cuti Sakit' ? 'selected' : '' }}>Sick Leave (Cuti Sakit)</option>
                                <option value="Cuti Melahirkan" {{ old('leave_type') == 'Cuti Melahirkan' ? 'selected' : '' }}>Maternity Leave (Cuti Melahirkan)</option>
                                <option value="Cuti Istri Melahirkan/Keguguran" {{ old('leave_type') == 'Cuti Istri Melahirkan/Keguguran' ? 'selected' : '' }}>Paternity Leave (Cuti Istri Melahirkan/Keguguran)</option>
                                <option value="Cuti Keguguran" {{ old('leave_type') == 'Cuti Keguguran' ? 'selected' : '' }}>Miscarriage Leave (Cuti Keguguran)</option>
                                <option value="Cuti Karyawan Menikah" {{ old('leave_type') == 'Cuti Karyawan Menikah' ? 'selected' : '' }}>Personal Marriage Leave (Cuti Karyawan Menikah)</option>
                                <option value="Cuti Kedukaan Keluarga Inti Meninggal Dunia" {{ old('leave_type') == 'Cuti Kedukaan Keluarga Inti Meninggal Dunia' ? 'selected' : '' }}>Compassionate Leave (Cuti Kedukaan Keluarga Inti Meninggal Dunia)</option>
                                <option value="Cuti Anak Khitan/Baptis" {{ old('leave_type') == 'Cuti Anak Khitan/Baptis' ? 'selected' : '' }}>Khitan/Baptism Leave (Cuti Anak Khitan/Baptis)</option>
                                <option value="Cuti Datang Terlambat" {{ old('leave_type') == 'Cuti Datang Terlambat' ? 'selected' : '' }}>Late To Work (Datang Terlambat)</option>
                                <option value="Cuti Pulang Cepat" {{ old('leave_type') == 'Cuti Pulang Cepat' ? 'selected' : '' }}>Leave Early (Pulang Cepat)</option>
                                <option value="Cuti Kedukaan Keluarga Serumah Meninggal Dunia" {{ old('leave_type') == 'Cuti Kedukaan Keluarga Serumah Meninggal Dunia' ? 'selected' : '' }}>Same Home Compassionate Leave (Cuti Kedukaan Keluarga Serumah Meninggal Dunia)</option>
                                <option value="Cuti Training" {{ old('leave_type') == 'Cuti Training' ? 'selected' : '' }}>Training</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input id="start_date" type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input id="end_date" type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Total Hari</label>
                            <p id="total_days_display" class="form-control-static"><strong>0 Hari</strong></p>
                        </div>

                        <div class="form-group">
                            <label for="reason">Alasan</label>
                            <textarea id="reason" class="form-control" name="reason" rows="4" required>{{ old('reason') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="replacement_employee_name">Nama Karyawan Pengganti (Opsional)</label>
                            <input id="replacement_employee_name" type="text" class="form-control" name="replacement_employee_name" value="{{ old('replacement_employee_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="attachment">Lampiran (PDF/JPG/PNG, maks 2MB)</label>
                            <input id="attachment" type="file" class="form-control" name="attachment">
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Kirim Pengajuan</button>
                         <a href="{{ route('leaves.pengajuan') }}" class="btn btn-default" style="margin-top: 20px;">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
            totalDaysDisplay.innerHTML = '<strong style="color: red;">Tanggal tidak valid</strong>';
        }
    }
    startDateInput.addEventListener('change', calculateDays);
    endDateInput.addEventListener('change', calculateDays);
    calculateDays(); // Hitung saat halaman dimuat
});
</script>
@endsection
