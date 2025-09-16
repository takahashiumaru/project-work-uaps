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

</head>

<body class="with-sidebar">
    @include('app')
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fas fa-users">Create / Update Schedule</h2>
                    <p>Sebuah informasi tentang jadwal yang terdaftar dalam sistem.</p>
                </div>
            </div>
            <div class="text-right">
                <form id="autoCreateForm" action="{{ route('schedule.autoCreate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Auto Create Schedule</button>
                </form>
            </div>
            <div class="text-right">
                <form action="{{ route('schedule.show') }}" method="GET" class="form-inline" style="margin-top: 10px;">
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
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->fullname }}</td>
                            <td>{{ $users->role }}</td>
                            <td>
                                <a href="{{ route('schedule.edit', ['id' => $users->id, 'page' => request('page')]) }}">
                                    <img src="{{ asset('storage/edit.png') }}" width="20" height="20" alt="Edit" style="margin-right: 10px;">
                                </a>
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

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @include('sweetalert::alert')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('autoCreateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Mohon tunggu...',
                text: 'Jadwal sedang diproses.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            e.target.submit();
        });
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
