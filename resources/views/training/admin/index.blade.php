@extends('layout.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Training /</span> Manajemen Training
</h4>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Seluruh Sertifikat</h5>
        <a href="{{ route('training.create') }}" class="btn btn-primary">Tambah Sertifikat</a>
    </div>
    <div class="card-body">
        <form action="{{ route('training.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NIP, atau nama sertifikat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                @if(request('search'))
                <a href="{{ route('training.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        {{-- Header disesuaikan agar sesuai dengan data binding yang ada --}}
                        <th>NIP</th>
                        <th>Nama Staff</th>
                        <th>Nama Sertifikat</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($certificates as $certificate)
                    {{-- Kelas untuk styling status kadaluarsa/mendekati kadaluarsa --}}
                    <tr class="{{ $certificate->is_expiring_soon ? 'bg-label-warning' : ($certificate->is_expired ? 'bg-label-danger' : '') }}">
                        {{-- Kolom Data --}}
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $certificate->nip ?? 'N/A' }}</strong></td>
                        <td>{{ $certificate->fullname ?? 'N/A' }}</td>
                        <td>{{ $certificate->certificate_name }}</td>
                        <td>{{ $certificate->start_date->format('d M Y') }}</td>
                        <td>{{ $certificate->end_date->format('d M Y') }}</td>

                        {{-- Kolom Status --}}
                        <td>
                            @if ($certificate->is_expired)
                            <span class="badge bg-danger">Kadaluarsa ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)</span>
                            @elseif ($certificate->is_expiring_soon)
                            <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa {{ $certificate->remaining_days }} hari)</span>
                            @else
                            <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>

                        {{-- Kolom File --}}
                        <td>
                            @if ($certificate->file_path)
                            {{-- Menggunakan icon boxicon dari admin layout --}}
                            <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat File">
                                <i class='bx bx-file'></i>
                            </a>
                            @else
                            N/A
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('training.edit', $certificate->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('training.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Paginasi --}}
        <div class="mt-3">
            {{ $certificates->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection