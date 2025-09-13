<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 650px;
        }

        .email-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.8s ease-out;
            position: relative;
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

        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 40px 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            animation: pulse 4s infinite ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
        }

        .header-icon {
            font-size: 64px;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            animation: float 3s ease-in-out infinite;
            color: #fff;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .body {
            padding: 40px 30px;
            text-align: center;
        }

        .greeting {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .message {
            font-size: 16px;
            margin-bottom: 25px;
            color: #555;
        }

        .highlight {
            color: #667eea;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }

        .highlight::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #667eea;
            border-radius: 1px;
        }

        .role-container {
            display: inline-block;
            background: linear-gradient(135deg, #f0f4ff, #e6eeff);
            border-radius: 16px;
            padding: 20px 30px;
            margin: 20px 0 30px;
            border-left: 4px solid #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .role-container::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0) 70%);
            border-radius: 50%;
        }

        .role-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .role-value {
            font-size: 24px;
            color: #667eea;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .button-container {
            margin: 30px 0;
        }

        .login-button {
            display: inline-block;
            padding: 18px 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(102, 126, 234, 0.4);
        }

        .features {
            display: flex;
            justify-content: space-around;
            margin: 40px 0 30px;
            flex-wrap: wrap;
        }

        .feature {
            text-align: center;
            width: 30%;
            min-width: 150px;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.05);
        }

        .feature:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.1);
        }

        .feature-icon {
            font-size: 36px;
            color: #667eea;
            margin-bottom: 12px;
        }

        .feature-text {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .footer {
            background: linear-gradient(135deg, #f9f9f9, #f1f1f1);
            padding: 25px 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 50%, rgba(0, 0, 0, 0) 100%);
            margin: 30px 0;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            opacity: 0.7;
        }

        .confetti:nth-child(1) {
            left: 10%;
            top: 20%;
            animation: fall 10s linear infinite;
            animation-delay: 0.5s;
            background: #8BC34A;
        }

        .confetti:nth-child(2) {
            left: 20%;
            top: 30%;
            animation: fall 8s linear infinite;
            animation-delay: 1s;
            background: #CDDC39;
        }

        .confetti:nth-child(3) {
            left: 70%;
            top: 10%;
            animation: fall 12s linear infinite;
            animation-delay: 1.5s;
            background: #FFEB3B;
        }

        .confetti:nth-child(4) {
            left: 80%;
            top: 50%;
            animation: fall 9s linear infinite;
            animation-delay: 2s;
            background: #FFC107;
        }

        .confetti:nth-child(5) {
            left: 40%;
            top: 70%;
            animation: fall 11s linear infinite;
            animation-delay: 0.8s;
            background: #FF9800;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @media (max-width: 600px) {
            .features {
                flex-direction: column;
                align-items: center;
            }

            .feature {
                width: 80%;
            }

            .header h1 {
                font-size: 28px;
            }

            .body {
                padding: 30px 20px;
            }

            .greeting {
                font-size: 24px;
            }

            .role-value {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-card">
            <!-- Confetti elements -->
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>
            <div class="confetti"></div>

            <!-- Header -->
            <div class="header">
                <div class="header-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Account Approved</h1>
            </div>

            <!-- Body -->
            <div class="body">
                <h2 class="greeting">Congratulations {{ $user->name }}!</h2>
                <p class="message">
                    We are excited to inform you that your account has been
                    <span class="highlight">successfully approved</span>.
                </p>

                <div class="role-container">
                    <div class="role-label">Role Assigned</div>
                    <div class="role-value">{{ $role }}</div>
                </div>

                <p class="message">
                    You can now log in and start exploring our platform with full access to all features.
                </p>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="feature-text">Access Courses</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">Track Progress</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="feature-text">Join Discussions</div>
                    </div>
                </div>

                <div class="button-container">
                    <a href="{{ url('/login') }}" class="login-button">Login Now</a>
                </div>

                <div class="divider"></div>

                <p class="message" style="font-size: 14px; color: #777;">
                    If you have any questions or need assistance, please don't hesitate to contact our support team.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>© {{ date('Y') }} Fajkings. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
