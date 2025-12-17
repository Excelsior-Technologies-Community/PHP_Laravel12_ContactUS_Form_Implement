<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>
