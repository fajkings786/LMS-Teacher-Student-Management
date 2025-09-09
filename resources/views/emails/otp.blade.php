<!DOCTYPE html>
<html>

<head>
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 50px 0;
            text-align: center;
            color: #333;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            max-width: 450px;
            margin: auto;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .otp {
            font-size: 36px;
            font-weight: bold;
            color: #ff6b81;
            letter-spacing: 5px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #667eea;
            color: #fff !important;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Hello {{ $user->name }}!</h2>
        <p>We are excited to have you onboard. Your OTP code for verifying your account is:</p>
        <div class="otp">{{ $otp }}</div>
        <p>Click the button below to verify your account now:</p>
        <a href="{{ route('otp.verify.form', ['email' => $user->email]) }}" class="btn">Verify Account</a>

        <p class="footer">If you did not request this, please ignore this email.</p>
    </div>
</body>

</html>
