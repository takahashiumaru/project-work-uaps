<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee Login</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">

    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="{{ asset('/assets/js/script.js') }}" defer></script>
</head>

<body class="page-login">
    <div class="login-container">
        @if ($errors->has('password') || session('error'))
        <div id="error-message" class="error-message">
            <span>
                {{ $errors->first('password') ?: session('error') }}
            </span>
            <i class="fas fa-times" onclick="closeError()"></i>
        </div>
        @endif
        <div class="left-panel">
            <h2>Employee Login</h2>

            @if ($errors->has('password'))
            <div id="error-message" class="error-message">
                <span>{{ $errors->first('password') }}</span>
                <i class="fas fa-times" onclick="closeError()"></i>
            </div>
            @endif

            <form action="{{ route('actionlogin') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="number" name="id" class="form-control" placeholder="NIP" required pattern="[0-9]*">
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i id="toggle-icon" class="fas fa-eye"></i>
                    </span>
                </div>
                <button class="login-btn" type="submit">Login</button>
            </form>
        </div>
        <div class="right-panel">
            <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" width="150">
        </div>
    </div>
</body>

</html>
