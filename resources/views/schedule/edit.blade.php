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
    @extends('app')
    @include('partials.sidebar')

    @include('partials.navbar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fas fa-users"> Schedule</h2>
                <p>Informasi terperinci mengenai jadwal yang telah terdaftar dalam sistem.</p>
            </div>
        </div>

        <div class="calendar">
            @php
            use Carbon\Carbon;
            $firstDay = Carbon::now()->startOfMonth()->dayOfWeek;
            $daysInMonth = Carbon::now()->daysInMonth;
            $scheduleMap = $schedules->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
            $shifts = \App\Models\Shift::all();
            @endphp

            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
            <div class="day-name">{{ $dayName }}</div>
            @endforeach

            @for($i = 0; $i < $firstDay; $i++)
                <div class="day inactive">
        </div>
        @endfor

        @for($date = 1; $date <= $daysInMonth; $date++)
            @php
            $tanggal=Carbon::now()->startOfMonth()->addDays($date - 1)->format('Y-m-d');
            $schedule = $scheduleMap[$tanggal] ?? null;
            @endphp
            <div class="day">
                <div class="date">{{ $date }}</div>

                <form method="POST" action="{{ route('schedule.update', ['userId' => $userId, 'date' => $tanggal]) }}">
                    @csrf
                    <select name="shift_id" class="form-control input-sm" onchange="this.form.submit()">
                        <option value="">-- Pilih Shift --</option>
                        @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}"
                            {{ optional($schedule)->shift_id == $shift->id ? 'selected' : '' }}>
                            {{ $shift->description }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>
            @endfor
    </div>
    <div class="text-right">
        <a href="{{ route('schedule.show', ['page' => $page]) }}" class="btn btn-warning">BACK</a>
    </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
