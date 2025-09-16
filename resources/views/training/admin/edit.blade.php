@extends('app')

@section('title', 'Halaman Training')
@section('content')
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Edit Sertifikat Training
        </h2>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header">
            Form Edit Sertifikat
        </div>
        <div class="card-body">
            <form action="{{ route('admin.training.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="user_id" class="form-label">Pilih Staff</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                        <option value="">-- Pilih Staff --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ (old('user_id', $certificate->user_id) == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }} (NIP: {{ $user->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="certificate_name" class="form-label">Nama Sertifikat Training</label>
                    <input type="text" class="form-control @error('certificate_name') is-invalid @enderror" id="certificate_name" name="certificate_name" value="{{ old('certificate_name', $certificate->certificate_name) }}" required>
                    @error('certificate_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Masa Berlaku Awal</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $certificate->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Masa Berlaku Akhir</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $certificate->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="certificate_file" class="form-label">File Sertifikat (PDF, JPG, PNG)</label>
                    <input type="file" class="form-control @error('certificate_file') is-invalid @enderror" id="certificate_file" name="certificate_file">
                    @error('certificate_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($certificate->file_path)
                        <div class="mt-2">
                            File saat ini: <a href="{{ Storage::url($certificate->file_path) }}" target="_blank">Lihat File</a>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_file" id="remove_file" value="1">
                                <label class="form-check-label" for="remove_file">
                                    Hapus File Saat Ini
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Sertifikat</button>
                <a href="{{ route('admin.training.certificates.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection