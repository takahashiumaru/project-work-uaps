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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css">

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

        th:nth-child(7),
        td:nth-child(7) {
            width: 18%;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 18%;
        }

        th:nth-child(9),
        td:nth-child(9) {
            width: 10%;
        }
    </style>

    <script src="{{ asset('/assets/js/script.js') }}" defer></script>
</head>

<body class="with-sidebar">
    @include('app')
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fas fa-users"> Shift</h2>
                    <p>Sebuah informasi tentang jadwal yang terdaftar dalam sistem.</p>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('shift.create') }}" class="btn btn-primary" style="margin-bottom: 10px;">
                    <i class="fa fa-plus-circle"></i> Create
                </a>
            </div>
            @yield('konten')

            
            <!-- Flight Table -->
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Jam Mulai</th>
                            <th>Jam Berakhir</th>
                            <th>Tenaga Kerja</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shifts as $shift)
                        <tr>
                            <td>{{ $shift->id }}</td>
                            <td>{{ $shift->name }}</td>
                            <td>{{ $shift->description }}</td>
                            <td>{{ $shift->start_time }}</td>
                            <td>{{ $shift->end_time }}</td>
                            <td>{{ $shift->use_manpower }} Orang</td>
                            <td>{{ $shift->created_at }}</td>
                            <td>{{ $shift->updated_at }}</td>
                            <td>
                                <a href="{{ route('shift.edit', $shift->id) }}">
                                    <img src="{{ asset('storage/edit.png') }}" width="20" height="20" alt="Edit" style="margin-right: 10px;">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
