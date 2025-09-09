<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account Approved</title>
</head>

<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f4f6f9; padding:30px;">
    <div
        style="max-width:650px; margin:auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.15);">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4CAF50, #2e7d32); padding:25px; text-align:center;">
            <h1 style="color:#fff; margin:0; font-size:26px;"> Account Approved </h1>
        </div>

        <!-- Body -->
        <div style="padding:30px; text-align:center; color:#333;">
            <h2 style="color:#4CAF50; margin-bottom:15px;">Congratulations {{ $user->name }}!</h2>
            <p style="font-size:16px; line-height:1.6; margin-bottom:20px;">
                We are excited to inform you that your account has been
                <strong style="color:#2e7d32;">successfully approved</strong>.
            </p>
            <p style="font-size:16px; line-height:1.6; margin-bottom:20px;">
                <b>Role Assigned:</b> <span style="color:#4CAF50;">{{ $role }}</span>
            </p>
            <p style="font-size:15px; line-height:1.6; margin-bottom:25px;">
                You can now log in and start exploring our platform.
            </p>

            <!-- Button -->
            <a href="{{ url('/login') }}"
                style="display:inline-block; padding:14px 28px; background:#4CAF50; color:#fff; text-decoration:none; border-radius:8px; font-weight:bold; transition:0.3s;">
                Login Now
            </a>
        </div>

        <!-- Footer -->
        <div
            style="background:#f9f9f9; padding:15px; text-align:center; font-size:13px; color:#777; border-top:1px solid #eee;">
            © {{ date('Y') }} Fajkings. All rights reserved.
        </div>
    </div>
</body>

</html>
