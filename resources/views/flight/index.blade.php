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

    <style>
        body {
            background: #fff;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            transition: padding-left 0.3s ease;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #fff;
            padding: 20px;
            color: #333;
            position: fixed;
            /* ubah absolute jadi fixed */
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1050;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar a {
            display: block;
            color: #333;
            padding: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .sidebar .logout {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }

        .toggle-btn-inside {
            background: #337ab7;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .navbar-custom {
            background-color: #fff;
            border-radius: 0;
            margin-left: 0;
            transition: margin-left 0.3s ease;
            z-index: 1000;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #000;
        }

        .navbar-custom .nav-link:hover {
            color: #555;
        }

        .main-content {
            margin-left: 0;
            margin-top: 60px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .with-sidebar .navbar-custom {
            margin-left: 250px;
        }

        .with-sidebar .main-content {
            margin-left: 250px;
        }

        .panel-heading {
            font-weight: bold;
        }

        #tanggalSekarang {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .clickable-row {
            cursor: pointer;
        }
    </style>

</head>

<body class="with-sidebar">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" width="150">
        <hr>
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('users.profile', Auth::user()->id) }}"><i class="fas fa-user"></i> Profile</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#scheduleDropdown">
                <i class="fas fa-users"></i> Schedule <i class="fas fa-caret-down pull-right"></i>
            </a>
            <div id="scheduleDropdown" class="collapse">
                <a href="{{ route('schedule.now') }}" style="padding-left: 30px;">Jadwal Schedule Hari Ini </a>
                <a href="{{ route('schedule.index') }}" style="padding-left: 30px;">Data Schedule</a>
                @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                <a href="{{ route('schedule.show') }}" style="padding-left: 30px;">Create / Update Schedule</a>
                @endif
            </div>
        </div>
        @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
        <a href="{{ route('shift.index') }}"><i class="bi bi-clock"></i> Shift</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#userDropdown">
                <i class="fas fa-users"></i> User <i class="fas fa-caret-down pull-right"></i>
            </a>
            <div id="userDropdown" class="collapse">
                <a href="{{ route('users.index') }}" style="padding-left: 30px;">Daftar User</a>
                <a href="{{ route('users.kontrak') }}" style="padding-left: 30px;">Kontrak</a>
                <a href="{{ route('users.pas') }}" style="padding-left: 30px;">PAS Tahunan</a>
            </div>
        </div>
        @endif
        <a href="{{ route('document') }}"><i class="bi bi-files"></i> Dokumen</a>
        <p id="tanggalSekarang"><i class="fas fa-clock"></i> Loading...</p>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Tombol toggle pindah ke sini -->
                <button class="btn btn-primary toggle-btn-inside navbar-btn" id="toggleSidebar" style="margin-right: 15px;">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><i class="fas fa-user"></i> Welcome, {{ Auth::user()->fullname }} - {{ Auth::user()->role }}</a></li>
                <li><a href="{{ route('actionlogout') }}"><i class="fa fa-power-off"></i> Log Out</a></li>
            </ul>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="main-content">
        <div class="container">

            <!-- Panel Info -->
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><i class="fas fa-database"></i> Total Staff</div>
                        <div class="panel-body">
                            <p><i class="fas fa-users"></i> <strong>{{ $userCount ?? 0 }}</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading"><i class="fas fa-chart-bar"></i> Staff Duty</div>
                        <div class="panel-body">
                            <p><i class="fas fa-user-check"></i> <strong>{{ $workingManpowers ?? 0 }}</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><i class="fas fa-plane"></i> Total Flight</div>
                        <div class="panel-body">
                            <p><i class="fas fa-plane"></i> <strong>{{ $totalFlightPerDay ?? 0 }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            @yield('konten')

            <!-- Add Button -->
            <div class="text-right">
                @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                <button type="button" class="btn btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#addFlightModal">
                    <i class="fa fa-plus-circle"></i> Add
                </button>
                @endif
            </div>

            <!-- Flight Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Airline</th>
                            <th>Flight Number</th>
                            <th>Registasi</th>
                            <th>Arrival</th>
                            <th>Time Count</th>
                            <th>Done</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flights as $flight)
                        <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#viewFlightModal{{ $flight->id }}">
                            <td>{{ $flight->id }}</td>
                            <td>{{ $flight->airline }}</td>
                            <td>{{ $flight->flight_number }}</td>
                            <td>{{ $flight->registasi }}</td>
                            <td>{{ $flight->arrival }}</td>
                            <td><span id="countdown-{{ $flight->id }}"></span></td>
                            <td class="no-click">
                                @if($flight->status)
                                Done
                                @else
                                @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                                <form action="{{ route('flights.update', $flight->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Mark as Done</button>
                                </form>
                                @else
                                <span class="text-warning">In Progress</span>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @include('modal.view_flight', ['flight' => $flight])
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const countdownElement = document.getElementById('countdown-{{ $flight->id }}');
                                const storageKey = 'targetTime-{{ $flight->id }}';
                                const expiredKey = 'expired-{{ $flight->id }}';

                                if (localStorage.getItem(expiredKey) === 'true') {
                                    countdownElement.textContent = 'EXPIRED';
                                    return;
                                }

                                let targetTime = localStorage.getItem(storageKey);

                                if (!targetTime) {
                                    targetTime = new Date();
                                    const timeParts = "{{ $flight->time_count }}".split(':');
                                    targetTime.setHours(targetTime.getHours() + parseInt(timeParts[0]));
                                    targetTime.setMinutes(targetTime.getMinutes() + parseInt(timeParts[1]));
                                    targetTime.setSeconds(targetTime.getSeconds() + parseInt(timeParts[2]));
                                    localStorage.setItem(storageKey, targetTime.toISOString());
                                } else {
                                    targetTime = new Date(targetTime);
                                }

                                function updateCountdown() {
                                    const now = new Date();
                                    const diff = targetTime - now;

                                    if (diff > 0) {
                                        const hours = Math.floor((diff % 86400000) / 3600000);
                                        const minutes = Math.floor((diff % 3600000) / 60000);
                                        const seconds = Math.floor((diff % 60000) / 1000);
                                        countdownElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                    } else {
                                        countdownElement.textContent = "EXPIRED";
                                        localStorage.setItem(expiredKey, 'true');
                                        localStorage.removeItem(storageKey);
                                        clearInterval(interval);
                                    }
                                }

                                updateCountdown();
                                const interval = setInterval(updateCountdown, 1000);
                            });
                        </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('modal.add_flight')

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        function updateTanggal() {
            const now = new Date();
            const tanggalFormat = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).format(now);
            document.getElementById('tanggalSekarang').textContent = `🕒 ${tanggalFormat}`;
        }
        setInterval(updateTanggal, 1000);
        updateTanggal();

        // Modal open prevention on specific buttons
        $(document).ready(function() {
            $('.clickable-row').click(function(e) {
                if ($(e.target).closest('.no-click, button, i').length === 0) {
                    const modalId = $(this).data('bs-target');
                    $(modalId).modal('show');
                }
            });
        });
    </script>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');

            sidebar.classList.toggle('collapsed');
            body.classList.toggle('with-sidebar');
        });
    </script>

</body>

</html>
