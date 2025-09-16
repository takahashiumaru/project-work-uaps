<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT. Angkasa Pratama Sejahtera</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- jQuery & Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="{{ asset('/assets/js/script.js') }}" defer></script>
</head>

<body class="with-sidebar">
    @extends('app') 
    @include('partials.sidebar')

    @include('partials.navbar')
    <!-- Konten -->
    <div class="main-content">
        <div class="center-wrapper">
            <div class="panel panel-default" style="width: 500px;">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Create Shift</h3>
                </div>
                <div class="panel-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('shift.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Jenis</label>
                            <input type="text" class="form-control" name="id" placeholder="Masukkan jenis shift">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama shift">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" name="description" placeholder="Masukkan deskripsi shift">
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai</label>
                            <input type="time" class="form-control" name="start_time">
                        </div>
                        <div class="form-group">
                            <label>Jam Berakhir</label>
                            <input type="time" class="form-control" name="end_time">
                        </div>
                        <div class="form-group">
                            <label>Tenaga Kerja</label>
                            <input type="number" class="form-control" name="use_manpower" placeholder="Masukkan tenaga kerja shift">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">CREATE</button>
                            <a href="{{ route('shift.index') }}" class="btn btn-warning">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
