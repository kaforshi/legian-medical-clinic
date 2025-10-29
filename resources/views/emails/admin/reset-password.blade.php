<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-container {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #667eea;
        }
        .email-header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            margin-bottom: 30px;
        }
        .email-body p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .reset-button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .reset-button:hover {
            opacity: 0.9;
        }
        .reset-link {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 12px;
            color: #495057;
        }
        .email-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .warning p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔐 Reset Password</h1>
            <p style="margin: 5px 0; color: #6c757d;">Legian Medical Clinic</p>
        </div>

        <div class="email-body">
            <p>Halo <strong>{{ $adminName }}</strong>,</p>
            
            <p>Kami menerima permintaan untuk mereset password akun admin Anda. Jika Anda tidak meminta reset password, abaikan email ini.</p>

            <p>Untuk mereset password Anda, klik tombol di bawah ini:</p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="reset-button">Reset Password</a>
            </div>

            <p>Atau salin dan tempel link berikut ke browser Anda:</p>
            
            <div class="reset-link">
                {{ $resetUrl }}
            </div>

            <div class="warning">
                <p><strong>⚠️ Penting:</strong></p>
                <p>Link reset password ini hanya berlaku selama <strong>60 menit</strong>. Setelah itu, Anda perlu meminta link baru.</p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini. Password Anda tidak akan berubah.</p>
            </div>
        </div>

        <div class="email-footer">
            <p>Email ini dikirim secara otomatis oleh sistem Legian Medical Clinic.</p>
            <p style="margin-top: 10px;">&copy; {{ date('Y') }} Legian Medical Clinic. All rights reserved.</p>
        </div>
    </div>
</body>
</html>



