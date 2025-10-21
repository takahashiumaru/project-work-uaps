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

<body class="with-create-user">
    @extends('app')
    @include('partials.sidebar')

    @include('partials.navbar')
    <div class="main-content-with-create-user">
        <div class="center-wrapper">
            <div class="panel panel-default" style="width: 500px;">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">CREATE USER</h3>
                </div>
                <div class="panel-body panel-scrollable">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('freelance.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="fullname" placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">CREATE</button>
                            <a href="{{ route('schedule.freelances') }}" class="btn btn-warning">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#unit_select').on('change', function() {
                var unitValue = $(this).val();
                var subUnitSelect = $('#sub_unit_select');


                subUnitSelect.val('');

                if (unitValue === 'baggage handling') {
                    subUnitSelect.val('porter apron');
                } else if (unitValue === 'baggage claim') {
                    subUnitSelect.val('porter makeup');
                } else if (unitValue === 'aircraft cleaning') {
                    subUnitSelect.val('aiec');
                }

            });
        });
    </script>
</body>

</html>
