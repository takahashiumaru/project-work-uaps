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

    <nav class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid d-flex align-items-center" style="gap: 10px;">
            <button class="btn btn-primary toggle-btn-inside navbar-btn" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <a href="#" class="btn btn-default navbar-btn pull-right" id="profileToggle" style="border: none; background: none;">
                <i class="fas fa-user"></i>
                <span class="user-fullname">Hi, {{ Auth::user()->fullname }}, {{ Auth::user()->role }}</span>
            </a>
        </div>
    </nav>

    <div class="card d-block d-sm-none" id="profileCard" style="position: fixed; top: 80px; right: 10px; z-index: 1050; width: 300px; display: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); background-color: #fff;">
        <div class="card-body text-center">
            <div class="profile-header">
                <i class="fas fa-user-circle" style="font-size: 50px; color: #4CAF50;"></i>
            </div>
            <h5 class="card-title mt-3" style="font-weight: bold;">{{ Auth::user()->fullname }}</h5>
            <p class="card-text" style="font-size: 14px; color: #666;">Role: {{ Auth::user()->role }}</p>
            <a href="{{ route('actionlogout') }}" class="btn btn-danger btn-sm w-100" style="border-radius: 25px;"><i class="fa fa-power-off"></i> Log Out</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h2 class="fa fa-address-card"> PAS</h2>
                <p>Sebuah informasi tanda izin masuk daerah terbatas pada area Bandar Udara.</p>
            </div>

            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Fullname</th>
                            <th>PAS Terdaftar</th>
                            <th>PAS Habis</th>
                            <th>Indikasi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->fullname }}</td>
                            <td>{{ $users->pas_registered }}</td>
                            <td>{{ $users->pas_expired }}</td>
                            <td>
                                @php
                                $now = strtotime(date('Y-m-d'));
                                $expired = strtotime($users->pas_expired);
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
                                <a href="{{ route('users.PASEdit', $users->id) }}">
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
