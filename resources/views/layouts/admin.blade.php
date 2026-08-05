<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    <style>
        .flip-card {
            perspective: 1000px;
        }
        .flip-card-inner {
            transition: transform 0.6s;
            transform-style: preserve-3d;
            position: relative;
        }
        .flip-card-inner.flipped {
            transform: rotateY(180deg);
        }
        .flip-card-front, .flip-card-back {
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        .flip-card-back {
            transform: rotateY(180deg);
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.admin-navbar')
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>
