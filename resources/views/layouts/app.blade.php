<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LMS - Learning Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 text-gray-900">
    {{-- Vue Components --}}

    @include('layouts.sidebar')
    {{-- Laravel Blade Content --}}
    <div class="container mx-auto p-6">
        @yield('content')
    </div>


</body>

</html>
