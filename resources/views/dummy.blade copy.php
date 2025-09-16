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
</head>

<body class="with-sidebar sidebar-open profile-body">
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

    <!-- Profile -->
    <div class="profile-wrapper" style="margin-top: 80px; padding: 20px; display: flex; justify-content: center;">
        <div class="profile-card" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); display: flex; align-items: center; gap: 40px; flex-wrap: wrap; max-width: 900px; width: 100%;">
            <form id="photoForm" method="POST" enctype="multipart/form-data" action="{{ route('user.updatePhoto', ['userId' => $user->id]) }}">
                @csrf
                <input type="file" name="profile_picture" id="fileInput" style="display: none;" onchange="document.getElementById('photoForm').submit();">

                <div style="text-align: center;">
                    <label for="fileInput" style="cursor: pointer;">
                        <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture): asset('storage/photo/user.jpg') }}"
                            alt="User Photo"
                            style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 4px solid #ccc;">

                    </label>
                    <h3 style="margin-top: 20px; font-weight: bold;">{{ $user->fullname }}</h3>
                    <p style="color: gray;">{{ $user->role ?? 'Title or Company' }}</p>
                </div>
            </form>

            <div style="display: grid; grid-template-columns: 150px 1fr; row-gap: 6px; font-size: 16px;">
                <div><strong>NIP</strong></div>
                <div>: {{ $user->id }}</div>
                <div><strong>Role</strong></div>
                <div>: {{ $user->role }}</div>
                <div><strong>Email</strong></div>
                <div>: {{ $user->email }}</div>
                <div><strong>Gender</strong></div>
                <div>: {{ $user->gender }}</div>
                <div><strong>Join Date</strong></div>
                <div>: {{ $user->join_date }}</div>
                <div><strong>Contract Start</strong></div>
                <div>: {{ $user->contract_start }}</div>
                <div><strong>Contract End</strong></div>
                <div>: {{ $user->contract_end }}</div>
                <div><strong>PAS Registered</strong></div>
                <div>: {{ $user->pas_registered }}</div>
                <div><strong>PAS Expired</strong></div>
                <div>: {{ $user->pas_expired }}</div>
                @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                <div><strong>Salary</strong></div>
                <div>: Rp {{ number_format($user->salary, 0, ',', '.') }}</div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>

</html>
