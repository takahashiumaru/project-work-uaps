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
                    <h2 class="fas fa-users"> Apron</h2>
                    <p>Sebuah informasi tentang pegawai yang terdaftar dalam sistem.</p>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary" style="margin-bottom: 10px;">
                    <i class="fa fa-plus-circle"></i> Create
                </a>
            </div>
            <div class="text-right">
                <form action="{{ route('users.apron') }}" method="GET" class="form-inline" style="margin-top: 10px;">
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
                {{ $user->links() }}
            </div>
            @yield('konten')
        </div>
    </div>

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
