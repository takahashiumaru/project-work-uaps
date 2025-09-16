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
    <!-- Navbar -->
    @include('partials.navbar')

    @include('partials.sidebar')

    <!-- Konten -->
    <div class="main-content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">EDIT</h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('users.KontrakUpdate', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="ID" value="{{ $user->id }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Kontrak Mulai</label>
                                    <input type="date" class="form-control" name="contract_start" value="{{ $user->contract_start }}">
                                </div>
                                <div class="form-group">
                                    <label>Kontrak Selesai</label>
                                    <input type="date" class="form-control" name="contract_end" value="{{ $user->contract_end }}">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">UPDATE</button>
                                    <a href="{{ route('users.kontrak', ['page' => $page]) }}" class="btn btn-warning">BACK</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
