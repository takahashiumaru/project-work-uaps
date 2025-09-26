@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">EDIT KONTRAK</h5>
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

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('users.KontrakUpdate', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="page" value="{{ $page }}">
                        
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-control" name="ID" value="{{ $user->id }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kontrak Mulai</label>
                            <input type="date" class="form-control" name="contract_start" value="{{ $user->contract_start }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kontrak Selesai</label>
                            <input type="date" class="form-control" name="contract_end" value="{{ $user->contract_end }}">
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>UPDATE
                            </button>
                            <a href="{{ route('users.kontrak', ['page' => $page]) }}" class="btn btn-warning">
                                <i class="bx bx-arrow-back me-1"></i>BACK
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script khusus untuk halaman edit kontrak
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi tanggal
        const contractStart = document.querySelector('input[name="contract_start"]');
        const contractEnd = document.querySelector('input[name="contract_end"]');
        
        if (contractStart && contractEnd) {
            contractStart.addEventListener('change', function() {
                if (contractEnd.value && this.value > contractEnd.value) {
                    alert('Tanggal mulai kontrak tidak boleh lebih besar dari tanggal selesai');
                    this.value = '';
                }
            });
            
            contractEnd.addEventListener('change', function() {
                if (contractStart.value && this.value < contractStart.value) {
                    alert('Tanggal selesai kontrak tidak boleh lebih kecil dari tanggal mulai');
                    this.value = '';
                }
            });
        }
    });
</script>
@endsection