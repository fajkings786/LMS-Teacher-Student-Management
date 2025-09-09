<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-sm transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-wide">OTP Verification</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 text-center font-medium shadow-inner">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4 text-center font-medium shadow-inner">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="text" name="otp" placeholder="Enter OTP"
                class="w-full border border-gray-300 p-4 rounded-xl text-center text-2xl tracking-widest focus:outline-none focus:ring-4 focus:ring-pink-300 focus:border-pink-500 transition"
                maxlength="6" required>

            <button type="submit"
                class="w-full bg-pink-500 text-white p-4 rounded-xl font-bold shadow-lg hover:bg-pink-600 transition-all transform hover:-translate-y-1">
                Verify OTP
            </button>
        </form>

        <p class="mt-6 text-center text-gray-500 text-sm">
            Didn't receive OTP?
        <form action="{{ route('otp.resend') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="text-pink-500 font-semibold hover:underline">
                Resend
            </button>
        </form>
        </p>
    </div>

</body>

</html>
