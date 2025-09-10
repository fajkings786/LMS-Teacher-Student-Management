<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
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
            max-width: 550px;
        }
        
        .email-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 4s infinite ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }
        
        .header-icon {
            font-size: 64px;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .body {
            padding: 40px 30px;
            text-align: center;
        }
        
        .greeting {
            font-size: 20px;
            color: #3b82f6;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .otp-container {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .otp-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .otp {
            font-size: 36px;
            font-weight: bold;
            color: #3b82f6;
            letter-spacing: 8px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
        }
        
        .otp::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 10%;
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            border-radius: 3px;
        }
        
        .expiry {
            font-size: 14px;
            color: #64748b;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .expiry-icon {
            margin-right: 8px;
            color: #ef4444;
        }
        
        .button-container {
            margin: 30px 0;
        }
        
        .reset-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .reset-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
        }
        
        .reset-button:hover::before {
            left: 100%;
        }
        
        .reset-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(59, 130, 246, 0.4);
        }
        
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 12px;
            color: #64748b;
            font-size: 14px;
        }
        
        .security-icon {
            margin-right: 10px;
            color: #3b82f6;
            font-size: 20px;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0) 100%);
            margin: 30px 0;
        }
        
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #94a3b8;
            text-align: center;
        }
        
        .help-text {
            font-size: 14px;
            color: #64748b;
            margin-top: 20px;
        }
        
        .company-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #94a3b8;
        }
        
        .steps {
            display: flex;
            justify-content: space-around;
            margin: 40px 0 30px;
            flex-wrap: wrap;
        }
        
        .step {
            text-align: center;
            width: 30%;
            min-width: 120px;
            margin-bottom: 20px;
        }
        
        .step-icon {
            font-size: 32px;
            color: #3b82f6;
            margin-bottom: 10px;
        }
        
        .step-text {
            font-size: 14px;
            color: #64748b;
        }
        
        @media (max-width: 600px) {
            .steps {
                flex-direction: column;
                align-items: center;
            }
            
            .step {
                width: 80%;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .body {
                padding: 30px 20px;
            }
            
            .otp {
                font-size: 28px;
                letter-spacing: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-card">
            <!-- Header -->
            <div class="header">
                <div class="header-icon">📩</div>
                <h1>Password Reset OTP</h1>
            </div>
            
            <!-- Body -->
            <div class="body">
                <div class="greeting">Hello,</div>
                <p class="message">
                    We received a request to reset your password. Use the OTP below to complete the process. This OTP is valid for a limited time.
                </p>
                
                <div class="otp-container">
                    <div class="otp-label">Your Password Reset Code</div>
                    <div class="otp">{{ $otp }}</div>
                    <div class="expiry">
                        <span class="expiry-icon">⏱️</span>
                        <span>This code will expire in 15 minutes</span>
                    </div>
                </div>
                
                <div class="steps">
                    <div class="step">
                        <div class="step-icon">1️⃣</div>
                        <div class="step-text">Enter OTP</div>
                    </div>
                    <div class="step">
                        <div class="step-icon">2️⃣</div>
                        <div class="step-text">Create New Password</div>
                    </div>
                    <div class="step">
                        <div class="step-icon">3️⃣</div>
                        <div class="step-text">Access Your Account</div>
                    </div>
                </div>
                
                <p class="message">
                    Or click the button below to reset your password directly:
                </p>
                
                <div class="button-container">
                    <a href="{{ url('/verify-otp-reset?email=' . $email) }}" class="reset-button">Reset Password</a>
                </div>
                
                <div class="security-note">
                    <span class="security-icon">🔒</span>
                    <span>For your security, never share this OTP with anyone. Our team will never ask for your OTP.</span>
                </div>
                
                <div class="divider"></div>
                
                <p class="help-text">
                    If you didn't request this password reset, please ignore this email or contact our support team immediately.
                </p>
                
                <div class="company-info">
                    <p>© {{ date('Y') }} Fajkings. All rights reserved.</p>
                    <p>Secure System | Protecting Your Data</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>