@extends('layout.admin')

@section('title', 'Create / Update Schedule')

@section('styles')
<style>
    .table-fixed {
        table-layout: fixed;
    }
    
    .table-fixed th:nth-child(1),
    .table-fixed td:nth-child(1) {
        width: 120px;
    }
    
    .table-fixed th:nth-child(2),
    .table-fixed td:nth-child(2) {
        width: 250px;
    }
    
    .table-fixed th:nth-child(3),
    .table-fixed td:nth-child(3) {
        width: 150px;
    }
    
    .table-fixed th:nth-child(4),
    .table-fixed td:nth-child(4) {
        width: 100px;
        text-align: center;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: #667eea;
        color: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .action-btn:hover {
        background: #5a6fd8;
        transform: translateY(-1px);
        color: white;
    }
    
    .search-box {
        max-width: 300px;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        opacity: 0.9;
        font-size: 0.875rem;
    }
    
    .auto-create-btn {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .auto-create-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .role-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .user-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
        
        .search-box {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Schedule /</span> Create / Update Schedule
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-user me-1"></i>
                        {{ $user->total() }} Users
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stats-card">
                <div class="stats-number">{{ $user->total() }}</div>
                <div class="stats-label">Total Users dalam Sistem</div>
                <small>Manage jadwal untuk semua user yang terdaftar</small>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form id="autoCreateForm" action="{{ route('schedule.autoCreate') }}" method="POST">
                @csrf
                <button type="submit" class="auto-create-btn">
                    <i class="bx bx-plus-circle me-2"></i> Auto Create Schedule
                </button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('schedule.show') }}" method="GET">
                <div class="input-group search-box">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i> Daftar User
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-fixed">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Fullname</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $users)
                                <tr>
                                    <td>
                                        <strong>{{ $users->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <img src="{{ $users->profile_picture ? asset('storage/photo/' . $users->profile_picture) : asset('storage/photo/user.jpg') }}" 
                                                 alt="{{ $users->fullname }}" 
                                                 class="user-avatar">
                                            <span>{{ $users->fullname }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary role-badge">{{ $users->role }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('schedule.edit', ['id' => $users->id, 'page' => request('page')]) }}" 
                                           class="action-btn"
                                           title="Edit Schedule">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
                        </div>
                        <nav>
                        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- Previous Page Link -->
        @if ($user->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $user->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @foreach ($user->getUrlRange(1, $user->lastPage()) as $page => $url)
            @if ($page == $user->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($user->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $user->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
</nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle me-2"></i> Informasi
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Klik tombol "Auto Create Schedule" untuk generate jadwal otomatis
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-edit text-primary me-2"></i>
                                    Klik icon edit untuk mengatur jadwal individual user
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-search text-info me-2"></i>
                                    Gunakan search box untuk mencari user tertentu
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-user text-warning me-2"></i>
                                    Total user yang ditampilkan: {{ $user->total() }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto Create Schedule with SweetAlert
        document.getElementById('autoCreateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Auto Create Schedule',
                text: 'Apakah Anda yakin ingin membuat jadwal secara otomatis?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#48bb78',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        // Submit the form
                        e.target.submit();
                        resolve();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });

        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'translateX(2px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'translateX(0)';
            });
        });

        // Add click effect to action buttons
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="bx bx-loader bx-spin"></i>';
                this.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.style.pointerEvents = 'auto';
                }, 1000);
            });
        });

        // Search box functionality
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }
    });

    // Show notification if there's a search term
    @if(request('search'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Pencarian',
            text: 'Menampilkan hasil untuk: "{{ request('search') }}"',
            icon: 'info',
            timer: 3000,
            showConfirmButton: false
        });
    });
    @endif
</script>
@endsection