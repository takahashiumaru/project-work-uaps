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
            width: 10%;
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
                    <h2 class="fas fa-calendar"> Kontrak</h2>
                    <p>Sebuah informasi tentang masa kontrak yang dimiliki oleh seorang pegawai.</p>
                </div>
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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Fullname</th>
                            <th>Kontrak Mulai</th>
                            <th>Kontrak End</th>
                            <th>Indikasi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->fullname }}</td>
                            <td>{{ $users->contract_start }}</td>
                            <td>{{ $users->contract_end }}</td>
                            <td>
                                @php
                                $now = strtotime(date('Y-m-d'));
                                $expired = strtotime($users->contract_end);
                                $diff = $expired - $now;
                                $months = floor($diff / (30 * 60 * 60 * 24));
                                @endphp
                                @if ($months <= 2 && $months>= 0)
                                    <span style="color: yellow; font-weight: bold">⚠️</span>
                                    @elseif ($months < 0)
                                        <span style="color: red; font-weight: bold">❌</span>
                                        @else
                                        <span style="color: green; font-weight: bold">✅</span>
                                        @endif
                            </td>
                            <td>
                                <a href="{{ route('users.KontrakEdit', ['id' => $users->id, 'page' => request('page')]) }}">
                                    <img src="{{ asset('storage/edit.png') }}" width="20" height="20" alt="Edit">
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
    @include('sweetalert::alert')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
