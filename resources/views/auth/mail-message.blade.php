<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
    <table align="center" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #eee;">
        <tr>
            <td align="center" style="background-color: #4A7EBB; padding: 30px 20px;">
                {{-- <img src="{{ asset('storage/aps_mini.png') }}"  alt="Logo" width="80" style="display:block; margin-bottom:15px;"> --}}
                <h2 style="color: #ffffff; margin: 0; font-family: Arial, sans-serif; font-size: 22px; letter-spacing: 0.5px;">Reset Password Akun Anda</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <p style="font-size: 16px; color: #333; margin-top: 0;">Halo, <strong>{{ $user->fullname }}</strong> 👋</p>
                <p style="font-size: 15px; color: #555; line-height: 1.5;">
                    Kami menerima permintaan untuk mereset password akun Anda. Silakan gunakan kode OTP di bawah ini untuk melanjutkan:
                </p>
                <div style="text-align: center; margin: 35px 0;">
                    <div style="display: inline-block; padding: 15px 30px; background-color: #f8fafc; border-radius: 12px; border: 2px dashed #4A7EBB;">
                        <span style="font-size: 36px; font-weight: 800; color: #4A7EBB; letter-spacing: 5px;">{{ $otp }}</span>
                    </div>
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
