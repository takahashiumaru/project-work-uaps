<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode OTP Reset Password</title>
</head>

<body style="margin:0; padding:0; background:#f4f7fb; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100%; background:#f4f7fb; margin:0; padding:34px 14px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100%; max-width:620px; border-collapse:separate; border-spacing:0;">
                    <tr>
                        <td style="padding:0 0 14px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="left" style="font-size:12px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#4a7ebb;">
                                        APSone Security
                                    </td>
                                    <td align="right" style="font-size:12px; color:#8a97aa;">
                                        Reset Password
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="overflow:hidden; border-radius:24px; background:#ffffff; border:1px solid #e6edf5; box-shadow:0 22px 56px rgba(31,41,55,0.10);">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:34px 36px 30px; background:linear-gradient(135deg,#4a7ebb 0%,#2f80ed 58%,#5cc7b2 100%);">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <div style="font-size:34px; line-height:1; font-weight:800; color:#ffffff; letter-spacing:0;">APS</div>
                                                    <div style="margin-top:8px; font-size:13px; font-weight:700; color:rgba(255,255,255,0.82); letter-spacing:0.08em; text-transform:uppercase;">PT. Angkasa Pratama Sejahtera</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:34px 36px 12px;">
                                        <h1 style="margin:0 0 12px; color:#1f2937; font-size:26px; line-height:1.25; font-weight:800; letter-spacing:0;">Kode Verifikasi Reset Password</h1>
                                        <p style="margin:0; color:#64748b; font-size:15px; line-height:1.7;">
                                            Halo, <strong style="color:#1f2937;">{{ $user->fullname }}</strong>. Gunakan kode OTP berikut untuk melanjutkan proses reset password akun APSone Anda.
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding:18px 36px 24px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:0;">
                                            <tr>
                                                <td align="center" style="min-width:260px; padding:20px 28px; border-radius:18px; background:#eef5ff; border:1px solid #cfe1ff; box-shadow:inset 0 0 0 1px rgba(255,255,255,0.65);">
                                                    <div style="margin-bottom:8px; font-size:11px; color:#4a7ebb; font-weight:800; letter-spacing:0.14em; text-transform:uppercase;">Kode OTP</div>
                                                    <div style="font-size:40px; line-height:1; font-weight:800; color:#2f6fcd; letter-spacing:0.18em;">{{ $otp }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 36px 28px;">
                                        <div style="padding:16px 18px; border-radius:16px; background:#fff8ed; border:1px solid #ffe3ad; color:#7a4b05; font-size:14px; line-height:1.65;">
                                            Kode ini berlaku selama <strong>10 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini dan akun Anda tetap aman.
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 36px 34px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #edf2f7;">
                                            <tr>
                                                <td align="center" style="padding-top:22px; color:#8a97aa; font-size:12px; line-height:1.6;">
                                                    Email ini dikirim otomatis oleh sistem APSone.
                                                    <br>
                                                    &copy; 2025 PT. Angkasa Pratama Sejahtera. All Rights Reserved.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
