<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account Rejected</title>
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
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
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
            max-width: 600px;
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
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
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

        .message {
            font-size: 18px;
            margin-bottom: 25px;
            color: #555;
        }

        .email {
            font-weight: 600;
            color: #ff6b6b;
            position: relative;
            display: inline-block;
        }

        .email::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #ff6b6b;
            border-radius: 1px;
        }

        .button-container {
            margin: 30px 0;
        }

        .contact-button {
            display: inline-block;
            padding: 16px 36px;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
        }

        .contact-button:hover::before {
            left: 100%;
        }

        .contact-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(255, 107, 107, 0.4);
        }

        .reason-container {
            background: #fff8f8;
            border-radius: 16px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #ff9a9e;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.1);
        }

        .reason-title {
            font-size: 18px;
            font-weight: 600;
            color: #ff6b6b;
            margin-bottom: 10px;
        }

        .reason-list {
            text-align: left;
            list-style-type: none;
        }

        .reason-list li {
            margin-bottom: 8px;
            padding-left: 25px;
            position: relative;
        }

        .reason-list li::before {
            content: "\f057";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #ff9a9e;
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
            color: #ff9a9e;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 50%, rgba(0, 0, 0, 0) 100%);
            margin: 30px 0;
        }

        @media (max-width: 600px) {
            .header h1 {
                font-size: 28px;
            }

            .body {
                padding: 30px 20px;
            }

            .message {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-card">
            <!-- Header -->
            <div class="header">
                <div class="header-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h1>Account Rejected</h1>
            </div>

            <!-- Body -->
            <div class="body">
                <h2 class="message">We're Sorry</h2>
                <p class="message">
                    The account request for <span class="email">{{ $email }}</span> has been rejected.
                </p>

                <div class="reason-container">
                    <div class="reason-title">Possible Reasons</div>
                    <ul class="reason-list">
                        <li>Incomplete or invalid information provided</li>
                        <li>Account already exists with this email</li>
                        <li>Verification documents not approved</li>
                        <li>Account does not meet our requirements</li>
                    </ul>
                </div>

                <p class="message">
                    If you think this was a mistake, or if you'd like more information about the rejection, please
                    contact our support team.
                </p>

                <div class="button-container">
                    <a href="mailto:support@example.com" class="contact-button">
                        <i class="fas fa-envelope mr-2"></i> Contact Support
                    </a>
                </div>

                <div class="divider"></div>

                <p class="message" style="font-size: 14px; color: #777;">
                    Thank you for your understanding. We appreciate your interest in our platform.
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
