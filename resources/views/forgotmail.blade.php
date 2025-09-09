<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .title {
            color: #3b82f6;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .message {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 1.5rem;
        }

        .otp {
            font-size: 28px;
            font-weight: bold;
            color: #ef4444;
            background: #fee2e2;
            padding: 10px 20px;
            border-radius: 10px;
            letter-spacing: 4px;
            margin-bottom: 2rem;
            display: inline-block;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: #3b82f6;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #9ca3af;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h2 class="title">📩 Password Reset OTP</h2>
            <p class="message">
                Hello, use the OTP below to reset your password. This OTP is valid for a limited time.
            </p>

            <div class="otp">{{ $otp }}</div>

            <p class="message">
                Or click the button below to reset your password directly:
            </p>
            <a href="{{ url('/reset-password-form') }}" class="btn">Reset Password</a>

            <div class="footer">
                If you didn't request this, please ignore this email. <br>
                Fajkings - Secure System
            </div>
        </div>
    </div>
</body>

</html>
