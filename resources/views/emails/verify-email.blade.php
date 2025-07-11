<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>

<body style="background:#f7fafc;padding:0;margin:0;font-family:Arial,sans-serif;color:#2d3748;">
    <table width="100%" bgcolor="#f7fafc" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="600" cellpadding="0" cellspacing="0" align="center"
                    style="margin:20px auto;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 0 10px rgba(0,0,0,0.1)">
                    <tr>
                        <td style="background:#319795;padding:20px;text-align:center;">
                            <h1 style="color:#fff;margin:0;">{{ $site }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('defaults/login.jpg') }}" alt="{{ app(\App\Settings\WebsiteSettings::class)->site_name }}" width="600"
                                height="200" style="display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px;">
                            <h2 style="margin-top:0;">Halo,</h2>
                            <p>Terima kasih telah mendaftar di <strong>{{ $site }}</strong>.</p>
                            <p>Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>

                            <p style="text-align:center;margin:30px 0;">
                                <a href="{{ $url }}"
                                    style="background:#319795;color:#fff;padding:12px 24px;text-decoration:none;border-radius:4px;display:inline-block;">
                                    Verifikasi Email
                                </a>
                            </p>

                            <p>Jika Anda tidak mendaftar akun di {{ $site }}, abaikan email ini.</p>

                            <p>Salam hangat,<br><strong>{{ $site }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#edf2f7;padding:15px;text-align:center;font-size:12px;color:#718096;">
                            &copy; {{ now()->year }} {{ $site }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
