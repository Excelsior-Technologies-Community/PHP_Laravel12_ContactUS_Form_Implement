<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                        Admin Panel
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:flex">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.contacts') }}" class="text-gray-600 hover:text-gray-900 font-medium {{ request()->routeIs('admin.contacts') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        Messages
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(Auth::check())
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Log Out
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>
