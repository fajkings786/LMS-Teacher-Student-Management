<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
        
        .container {
            width: 100%;
            max-width: 500px;
        }
        
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 4s infinite ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }
        
        .card-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .card-header p {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .card-body {
            padding: 40px 30px;
            text-align: center;
        }
        
        .welcome-message {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .instruction {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .otp-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .otp-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .otp {
            font-size: 42px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            position: relative;
            display: inline-block;
        }
        
        .otp::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 3px;
        }
        
        .btn-container {
            margin: 30px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
        }
        
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            line-height: 1.5;
        }
        
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
            color: #666;
        }
        
        .security-icon {
            margin-right: 10px;
            color: #667eea;
            font-size: 20px;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0) 100%);
            margin: 30px 0;
        }
        
        .help-text {
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
        
        .company-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #888;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 500px) {
            .card-body {
                padding: 30px 20px;
            }
            
            .otp {
                font-size: 32px;
                letter-spacing: 5px;
            }
            
            .btn {
                padding: 14px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="logo">🎓</div>
                <h1>Verify Your Account</h1>
                <p>Learning Management System</p>
            </div>
            <div class="card-body">
                <div class="welcome-message">Hello {{ $user->name }}!</div>
                <p class="instruction">Thank you for registering with our Learning Management System. To complete your registration and secure your account, please use the verification code below:</p>
                
                <div class="otp-container">
                    <div class="otp-label">Your Verification Code</div>
                    <div class="otp">{{ $otp }}</div>
                </div>
                
                <div class="btn-container">
                    <a href="{{ route('otp.verify.form', ['email' => $user->email]) }}" class="btn">Verify Account</a>
                </div>
                
                <div class="divider"></div>
                
                <div class="security-note">
                    <span class="security-icon">🔒</span>
                    <span>For your security, this code will expire in 15 minutes. Please do not share this code with anyone.</span>
                </div>
                
                <p class="help-text">If you did not request this verification code, please disregard this email or contact our support team immediately.</p>
                
                <div class="company-info">
                    <p>© {{ date('Y') }} Learning Management System. All rights reserved.</p>
                    <p>If you have any questions, contact our support team at faisaljavedakhtarkhan@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>