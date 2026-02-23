@extends('layout.admin')
@section('title', 'Input Lembur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Form Pengajuan Lembur</div>
        <div class="card-body mt-4">
            <form action="{{ route('overtime.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tanggal Lembur</label>
                    <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Loading Cargo Qantas" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Durasi (Jam)</label>
                    <input type="number" name="duration" class="form-control" placeholder="1" min="1" required>
                    <div class="form-text">Masukkan total jam lembur.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi Detail</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="{{ route('overtime.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection