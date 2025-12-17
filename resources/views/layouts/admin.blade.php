<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @include('layouts.admin-navbar')  <!-- sirf admin ke liye navbar -->
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>
