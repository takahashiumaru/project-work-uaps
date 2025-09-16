<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            display: flex;
            width: 800px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #f8f8f8;
        }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .right-panel img {
            max-width: 60%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            position: relative;
            width: 100%;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function togglePassword(id, iconId) {
            var passwordField = document.getElementById(id);
            var toggleIcon = document.getElementById(iconId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        function validateForm(event) {
            var password = document.getElementById("password").value;
            var passwordConfirmation = document.getElementById("password_confirmation").value;
            var errorMessage = document.getElementById("error-message");

            if (password.length < 6) {
                errorMessage.innerText = "Password harus lebih dari 6 karakter.";
                event.preventDefault(); // Mencegah submit form
                return false;
            }

            if (password !== passwordConfirmation) {
                errorMessage.innerText = "Konfirmasi password tidak cocok.";
                event.preventDefault();
                return false;
            }

            errorMessage.innerText = ""; // Hapus pesan error jika tidak ada masalah
            return true;
        }
    </script>
</head>

<body>
    <div class="login-container">
        <div class="left-panel">
            <h2>Change Password</h2>
            <form action="{{ route('update.password') }}" method="post" onsubmit="return validateForm(event)">
                @csrf
                <p id="error-message" class="error-message"></p>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password Baru" required>
                    <span class="toggle-password" onclick="togglePassword('password', 'toggle-icon-password')">
                        <i id="toggle-icon-password" class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru" required>
                    <span class="toggle-password" onclick="togglePassword('password_confirmation', 'toggle-icon-confirmation')">
                        <i id="toggle-icon-confirmation" class="fas fa-eye"></i>
                    </span>
                </div>
                <button class="login-btn" type="submit">Ubah Password</button>
            </form>
        </div>
        <div class="right-panel">
            <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" width="150">
        </div>
    </div>
</body>

</html>
