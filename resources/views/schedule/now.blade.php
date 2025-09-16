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
        <div class="header">
            <h2 class="fas fa-calendar-day"> Jadwal Hari Ini - {{ $today->format('d M Y') }}</h2>
        </div>

        @forelse ($shiftsGrouped as $group)
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>Shift {{ $group['shift']->id }} - {{ $group['shift']->description }} - {{ $group['shift']->use_manpower }} Orang</strong><br>
                <small>{{ $group['shift']->start_time }} - {{ $group['shift']->end_time }}</small>
            </div>
            <div class="panel-body">
                @foreach ($group['schedules'] as $schedule)
                <p>
                    {{ $schedule->user->fullname ?? 'Tidak ditemukan' }} | {{ $schedule->user_id }}
                    @if ($schedule->user && $schedule->user->is_qantas == 1)
                    | Qantas
                    @endif
                    @if ($schedule->user && $schedule->is_active == 1)
                    | Active
                    @elseif ($schedule->user && $schedule->is_active == 0)
                    | Non Active
                    @endif

                    @if(auth()->user()->role == 'Leader Apron' || in_array(auth()->user()->role, ['SPV']))
                    <label class="switch">
                        <input type="checkbox"
                            class="attendance-toggle"
                            data-id="{{ $schedule->id }}"
                            {{ $schedule->is_active ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                    @endif
                </p>
                @endforeach

            </div>
        </div>
        @empty
        <p>Tidak ada jadwal untuk hari ini.</p>
        @endforelse
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).on('change', '.attendance-toggle', function() {
            let scheduleId = $(this).data('id');
            let isActive = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/schedules/update-active',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: scheduleId,
                    is_active: isActive
                },
                success: function(res) {
                    console.log(res.message);
                },
                error: function(err) {
                    alert('Gagal update status!');
                }
            });
        });
    </script>
</body>

</html>
