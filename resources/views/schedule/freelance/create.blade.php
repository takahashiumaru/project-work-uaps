@extends('layout.admin')

@section('title', 'Tambah Freelance')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header dengan Breadcrumb --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Tambah Freelance Baru</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Schedule</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Data Freelance</a></li>
                        <li class="breadcrumb-item active">Tambah Freelance</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Form Create --}}
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-user-plus me-2"></i>Form Tambah Freelance Baru
                            </h5>
                            <p class="mb-0 mt-1 small opacity-75">Isi form berikut untuk menambahkan freelance baru ke
                                sistem</p>
                        </div>
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h6 class="alert-heading">Terjadi kesalahan:</h6>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('freelance.store') }}" method="POST" id="createFreelanceForm">
                                @csrf

                                <div class="row">
                                    {{-- Kolom Kiri --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="fullname"
                                                placeholder="Masukkan nama lengkap" value="{{ old('fullname') }}" required>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Masukkan email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-info">
                                        <i class="bx bx-save me-1"></i>CREATE FREELANCE
                                    </button>
                                    <a href="{{ route('schedule.freelances') }}" class="btn btn-warning">
                                        <i class="bx bx-arrow-back me-1"></i>KEMBALI
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Validasi form sebelum submit
            const form = document.getElementById('createFreelanceForm');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap isi semua field yang wajib diisi',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    // Konfirmasi sebelum submit
                    e.preventDefault();
                    Swal.fire({
                        title: 'Buat Freelance Baru?',
                        text: 'Apakah Anda yakin ingin membuat freelance baru dengan data yang telah diisi?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4180c3',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Ya, Buat Freelance!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bootstrapAlert = new bootstrap.Alert(alert);
                    bootstrapAlert.close();
                });
            }, 5000);

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endsection

@section('styles')
    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .form-label {
            font-weight: 500;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
@endsection
