<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
    <table align="center" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="background-color: #0d6efd; padding: 20px;">
                {{-- <img src="{{ asset('storage/aps.jpeg') }}"  alt="Logo" width="120" style="display:block; margin-bottom:10px;"> --}}
                <h2 style="color: #ffffff; margin: 0;">Reset Password Akun Anda</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; color: #333;">Halo, <strong>{{ $user->fullname }}</strong> 👋</p>
                <p style="font-size: 15px; color: #555;">
                    Kami menerima permintaan untuk mereset password akun Anda. Berikut kode OTP Anda:
                </p>
                <div style="text-align: center; margin: 25px 0;">
                    <span style="font-size: 30px; font-weight: bold; color: #0d6efd;">{{ $otp }}</span>
                </div>
                <p style="font-size: 14px; color: #888;">
                    Kode ini hanya berlaku selama <strong>10 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                </p>
                <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
                <p style="font-size: 13px; color: #999; text-align: center;">
                    &copy; {{ date('Y') }} APSone. Semua hak dilindungi.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
