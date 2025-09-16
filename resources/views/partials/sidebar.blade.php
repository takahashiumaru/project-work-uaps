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
            @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader Bge', 'Ass Leader Apron', 'Head Of Airport Service', 'SPV', 'Bge', 'Apron']))
            <a href="{{ route('schedule.show') }}" style="padding-left: 30px;">Create / Update Schedule</a>
            @endif
        </div>
    </div>

    <a href="{{ route('shift.index') }}">
        <i class="bi bi-clock"></i> Shift
    </a>

    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#attendanceDropdown">
            <i class="fas fa-clipboard-check"></i> Attendance <i class="fas fa-caret-down pull-right"></i>
        </a>
        <div id="attendanceDropdown" class="collapse">
            <a href="{{ route('attendance.index') }}" style="padding-left: 30px;">Absensi Hari Ini</a>
            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
            <a href="{{ route('attendance.reports') }}" style="padding-left: 30px;">Laporan Absensi</a>
            @endif
        </div>
    </div>

    @if (in_array(Auth::user()->role, ['Admin']))
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#userDropdownMain">
            <i class="fas fa-users"></i> User <i class="fas fa-caret-down pull-right"></i>
        </a>

        <div id="userDropdownMain" class="collapse ml-3">
            <a href="{{ route('users.kontrak') }}" style="padding-left: 30px;">Kontrak</a>
            <a href="{{ route('users.pas') }}" style="padding-left: 30px;">PAS Tahunan</a>

            <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#subUserDropdown" style="padding-left: 30px;">
                <i class="fas fa-users"></i> Daftar User <i class="fas fa-caret-down pull-right"></i>
            </a>

            <div id="subUserDropdown" class="collapse ml-3">
                <a href="{{ route('users.apron') }}" style="padding-left: 60px;">Porter Apron</a>
                <a href="{{ route('users.bge') }}" style="padding-left: 60px;">Porter BGE</a>
                <a href="{{ route('users.office') }}" style="padding-left: 60px;">Office</a>
            </div>
        </div>
    </div>
    @endif

    <a href="{{ route('document') }}"><i class="bi bi-files"></i> Dokumen</a>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#trainingDropdown">
            <i class="fas fa-certificate"></i> Training <i class="fas fa-caret-down pull-right"></i>
        </a>
        <div id="trainingDropdown" class="collapse">
            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
            <a href="{{ route('training.index') }}" class="dropdown-item ps-4">Manajemen Training</a>
            <a href="{{ route('training.create') }}" class="dropdown-item ps-4">Tambah Sertifikat</a>
            @else
            <a href="{{ route('my.certificates') }}" class="dropdown-item ps-4">Sertifikat Training Saya</a>
            @endif
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#applyLeaveDropdown">
            <i class="fas fa-sign-out-alt"></i> Apply Leave <i class="fas fa-caret-down pull-right"></i>
        </a>
        <div id="applyLeaveDropdown" class="collapse">
            <a href="{{ route('leaves.pengajuan') }}" class="dropdown-item ps-4">Pengajuan Leave</a>
            @if (in_array(Auth::user()->role, ['Leader', 'Ass Leader', 'Admin', 'SPV']))
            <a href="{{ route('leaves.index') }}" class="dropdown-item ps-4">Approval Leave</a>
            <a href="{{ route('leaves.laporan') }}" class="dropdown-item ps-4">Laporan Leave</a>
            @endif
        </div>
    </div>
    <p id="tanggalSekarang"><i class="fas fa-clock"></i> Loading...</p>
</div>
