<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Angkasa Pratama Sejahtera</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="{{ asset('/assets/js/script.js') }}" defer></script>
    <style>
        table {
            width: 1000px;
            min-width: 1000px;
            border-collapse: collapse;
        }

        th,
        td {
            white-space: nowrap;
            padding: 8px;
            text-align: left;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 15%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 15%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 15%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 15%;
        }
    </style>
</head>

<body class="with-sidebar">
    @include('app')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fas fa-users"> User</h2>
                    <p>Sebuah informasi tentang pegawai yang terdaftar dalam sistem.</p>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary" style="margin-bottom: 10px;">
                    <i class="fa fa-plus-circle"></i> Create
                </a>
            </div>
            <div class="text-right">
                <form action="{{ route('users.index') }}" method="GET" class="form-inline" style="margin-top: 10px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari NIP / Nama" value="{{ request('search') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-fixed">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Fullname</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->fullname }}</td>
                            <td>{{ $users->role }}</td>
                            <td>{{ $users->created_at }}</td>
                            <td>{{ $users->updated_at }}</td>
                            <td>
                                <a href="{{ route('users.show', ['user' => $users->id, 'page' => request('page')]) }}">
                                    <img src="{{ asset('storage/eye.png') }}" width="20" height="20" alt="Show" style="margin-right: 10px;">
                                </a>

                                <a href="{{ route('users.edit', ['user' => $users->id, 'page' => request('page')]) }}">
                                    <img src="{{ asset('storage/edit.png') }}" width="20" height="20" alt="Edit" style="margin-right: 10px;">
                                </a>
                                <form action="{{ route('users.destroy', $users->id) }}" method="POST" style="display:inline;" data-confirm-delete="True" onsubmit="return confirm('Apakah Anda Yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; padding: 0;">
                                        <img src="{{ asset('storage/delete.png') }}" width="20" height="20" alt="Delete" style="margin-right: 10px;">
                                    </button>
                                </form>
                                <form id="resetPasswordForm-{{ $users->id }}" action="{{ route('user.resetPassword', $users->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="confirmReset({{ $users->id }})" style="background: none; border: none; padding: 0;">
                                        <img src="{{ asset('storage/reset.png') }}" width="20" height="20" alt="Reset Password">
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $user->links('pagination::bootstrap-5') }}
            </div>
            @yield('konten')
        </div>
    </div>
    <div class="modal fade" id="banModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="bx bx-error-alt me-2"></i> Blacklist Staff (PHK & Ban)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning text-start">
                        <strong>PERINGATAN:</strong><br>
                        Tindakan ini akan <b>menonaktifkan akun</b> staff dan mencatat namanya ke dalam daftar hitam perusahaan selamanya (berdasarkan NIP/KTP).
                    </div>
                    
                    {{-- ID User yang akan di-ban --}}
                    <input type="hidden" name="user_id" id="ban_user_id">
                    
                    <div class="mb-3 text-start">
                        <label class="form-label">Nama Staff</label>
                        <input type="text" class="form-control" id="ban_user_name" readonly style="background-color: #f5f5f5;">
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold text-danger">Alasan Pelanggaran (Wajib Diisi)</label>
                        <textarea name="reason" class="form-control" rows="4" required 
                                  placeholder="Contoh: Terbukti melakukan pencurian aset kabel di Station CGK pada tanggal..."></textarea>
                        <div class="form-text">Jelaskan kasusnya secara detail untuk rekam jejak HRD.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Blacklist</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBanModal(id, name) {
    // Isi data ke dalam form modal
    document.getElementById('ban_user_id').value = id;
    document.getElementById('ban_user_name').value = name;
    
    // Tampilkan Modal
    var myModal = new bootstrap.Modal(document.getElementById('banModal'));
    myModal.show();
}
</script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReset(userId) {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Apakah Anda ingin mereset password pengguna ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('resetPasswordForm-' + userId).submit();
                }
            });
        }
    </script>


    @include('sweetalert::alert')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
