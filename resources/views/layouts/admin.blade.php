<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">

        <!-- Navigation -->
        <nav class="bg-gray-900 text-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <!-- Left Nav -->
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">
                            {{ config('app.name', 'Laravel') }} Admin
                        </a>

                        <div class="hidden md:flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">Users</a>
                            <a href="{{ route('admin.priorities.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('admin.priorities.*') ? 'bg-gray-800' : '' }}">Priorities</a>
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800' : '' }}">Categories</a>
                            <a href="{{ route('admin.labels.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('admin.labels.*') ? 'bg-gray-800' : '' }}">Labels</a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center focus:outline-none">
                            <span class="mr-2 font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.44l3.71-4.21a.75.75 0 011.08 1.04l-4.25 4.82a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-800 z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">User Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS (for dismissible alerts, dropdowns etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
