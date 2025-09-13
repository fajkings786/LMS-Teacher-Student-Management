<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake { animation: shake 0.5s ease-in-out; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.6s ease-out; }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .otp-input {
            width: 3rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            position: relative;
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background-color: #f9fafb;
        }
        
        .otp-input:focus {
            outline: none;
            border-color: #ec4899;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.15);
            transform: translateY(-2px);
            animation: pulse 0.5s ease-in-out;
        }
        
        .otp-input::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #ec4899, #8b5cf6);
            border-radius: 3px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .otp-input:focus::after {
            transform: scaleX(1);
        }
        
        .otp-container {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
        }
        
        @media (max-width: 480px) {
            .otp-input {
                width: 2.5rem;
                height: 3rem;
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-sm transform transition duration-500 hover:scale-105 fade-in">
        <div class="text-center mb-6">
            <div class="text-6xl mb-4"></div>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-wide">OTP Verification</h2>
            <p class="text-gray-600 mt-2">Enter the verification code sent to your email</p>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 text-center font-medium shadow-inner flex items-center justify-center">
                <span class="mr-2">✓</span>
                {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4 text-center font-medium shadow-inner flex items-center justify-center">
                <span class="mr-2">⚠</span>
                {{ $errors->first() }}
            </div>
        @endif
        
        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <!-- Hidden input to combine all OTP digits -->
            <input type="hidden" name="otp" id="combined-otp">
            
            <div class="otp-container">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="0">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="1">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="2">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="3">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="4">
                <input type="text" maxlength="1" 
                    class="otp-input rounded-xl transition" required
                    data-index="5">
            </div>
            
            <button type="submit"
                class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white p-4 rounded-xl font-bold shadow-lg hover:from-pink-600 hover:to-purple-700 transition-all transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Verify OTP
            </button>
        </form>
        
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">Didn't receive OTP?</p>
            <form action="{{ route('otp.resend') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-pink-500 font-semibold hover:underline transition-colors">
                    Resend OTP
                </button>
            </form>
        </div>
        
        <div class="mt-8 bg-gray-50 rounded-xl p-4 text-sm">
            <div class="flex items-center mb-3">
                <div class="text-pink-500 mr-3 text-xl">📧</div>
                <div>
                    <div class="font-medium text-gray-800">Check your email</div>
                    <div class="text-gray-500">We've sent a 6-digit code to 
                        {{ substr($email, 0, 2) }}***@{{ substr(strstr($email, '@'), 1) }}</div>
                </div>
            </div>
            <div class="flex items-center">
                <div class="text-pink-500 mr-3 text-xl">⏱️</div>
                <div>
                    <div class="font-medium text-gray-800">Code expires</div>
                    <div class="text-gray-500">
                        Your OTP will expire in 
                        <span class="font-semibold text-red-500">15:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const combinedOtpInput = document.getElementById('combined-otp');
            
            // Function to combine all OTP digits
            function updateCombinedOtp() {
                let otpValue = '';
                otpInputs.forEach(input => {
                    otpValue += input.value;
                });
                combinedOtpInput.value = otpValue;
            }
            
            // Add event listeners to each OTP input
            otpInputs.forEach((input, index) => {
                // When a digit is entered
                input.addEventListener('input', function() {
                    // Move to next input if current is filled
                    if (input.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    updateCombinedOtp();
                });
                
                // When a key is pressed
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').trim();
                    if (/^\d{6}$/.test(pastedData)) {
                        // Fill all inputs with pasted digits
                        for (let i = 0; i < 6; i++) {
                            otpInputs[i].value = pastedData[i] || '';
                        }
                        // Focus on the last input
                        otpInputs[5].focus();
                        updateCombinedOtp();
                    }
                });
            });
            
            // Focus on first input on load
            if (otpInputs.length > 0) {
                otpInputs[0].focus();
            }
        });
    </script>
</body>
</html>