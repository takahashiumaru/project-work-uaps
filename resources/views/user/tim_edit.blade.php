@extends('layout.admin')

@section('title', 'Edit TIM Bandara')

@section('content')
@php
    $formatDate = fn ($date) => $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : '';
    $statusClass = 'secondary';
    $statusText = 'Belum Diisi';
    $statusDetail = 'Tanggal berakhir TIM belum tersedia.';

    if ($user->tim_expired) {
        $expired = \Carbon\Carbon::parse($user->tim_expired)->startOfDay();
        $daysLeft = now()->startOfDay()->diffInDays($expired, false);

        if ($daysLeft < 0) {
            $statusClass = 'danger';
            $statusText = 'Kadaluarsa';
            $statusDetail = 'TIM telah kadaluarsa sejak '.abs($daysLeft).' hari yang lalu.';
        } elseif ($daysLeft <= 30) {
            $statusClass = 'danger';
            $statusText = 'Critical';
            $statusDetail = 'Sisa masa berlaku TIM '.$daysLeft.' hari.';
        } elseif ($daysLeft <= 60) {
            $statusClass = 'warning';
            $statusText = 'Warning';
            $statusDetail = 'Sisa masa berlaku TIM '.$daysLeft.' hari.';
        } else {
            $statusClass = 'success';
            $statusText = 'Aktif';
            $statusDetail = 'Sisa masa berlaku TIM '.$daysLeft.' hari.';
        }
    }
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <h4 class="fw-bold mb-0">Edit TIM Bandara</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.tim') }}">TIM Bandara</a></li>
                    <li class="breadcrumb-item active">Edit TIM</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-edit me-2"></i>Edit Data TIM
                        </h5>
                        <p class="mb-0 mt-1 small opacity-75">Perbarui nomor dan masa berlaku TIM karyawan</p>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.TIMUpdate', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" value="{{ $user->id }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $user->fullname }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Station</label>
                                <input type="text" class="form-control" value="{{ $user->station }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor TIM</label>
                                <input type="text" class="form-control" name="tim_number" value="{{ old('tim_number', $user->tim_number) }}" maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">TIM Terdaftar</label>
                                <input type="date" class="form-control" name="tim_registered" value="{{ old('tim_registered', $formatDate($user->tim_registered)) }}">
                                <small class="text-muted">Tanggal ketika TIM pertama kali terdaftar</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">TIM Berakhir</label>
                                <input type="date" class="form-control" name="tim_expired" value="{{ old('tim_expired', $formatDate($user->tim_expired)) }}">
                                <small class="text-muted">Tanggal berakhirnya masa berlaku TIM</small>
                            </div>

                            <div class="alert alert-{{ $statusClass }} mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-id-card me-2"></i>
                                    <div>
                                        <strong>Status TIM: {{ $statusText }}</strong>
                                        <div class="small">{{ $statusDetail }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>UPDATE
                                </button>
                                <a href="{{ route('users.tim') }}" class="btn btn-warning">
                                    <i class="bx bx-arrow-back me-1"></i>BACK
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timRegistered = document.querySelector('input[name="tim_registered"]');
        const timExpired = document.querySelector('input[name="tim_expired"]');
        const form = document.querySelector('form');

        function isInvalidRange() {
            return timRegistered.value && timExpired.value && timRegistered.value > timExpired.value;
        }

        [timRegistered, timExpired].forEach(function(input) {
            input.addEventListener('change', function() {
                if (isInvalidRange()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Tanggal terdaftar tidak boleh lebih besar dari tanggal berakhir',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    input.value = '';
                }
            });
        });

        form.addEventListener('submit', function(event) {
            if (!isInvalidRange()) {
                return;
            }

            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Tanggal terdaftar tidak boleh lebih besar dari tanggal berakhir'
            });
        });
    });
</script>
@endsection
