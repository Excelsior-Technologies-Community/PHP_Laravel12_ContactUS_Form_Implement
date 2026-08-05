<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('contact.form') }}" class="text-xl font-bold text-blue-600">
                        Contact Us
                    </a>
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('contact.form') }}" class="text-gray-600 hover:text-gray-900 font-medium {{ request()->routeIs('contact.form') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            Contact Form
                        </a>
                        <a href="{{ route('contact.tracking.form') }}" class="text-gray-600 hover:text-gray-900 font-medium {{ request()->routeIs('contact.tracking.form') || request()->routeIs('contact.tracking') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                            Track Message
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>
