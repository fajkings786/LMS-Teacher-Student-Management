<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        <login-form></login-form>
    </div>
</body>

</html>
