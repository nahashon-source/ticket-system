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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold">
                            {{ config('app.name', 'Laravel') }} Admin
                        </a>
                        <div class="hidden md:flex space-x-4 ml-10">
                            <a href="{{ route('admin.dashboard') }}" class="hover:bg-gray-700 px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="hover:bg-gray-700 px-3 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">Users</a>
                            <a href="{{ route('admin.priorities.index') }}" class="hover:bg-gray-700 px-3 py-2 rounded {{ request()->routeIs('admin.priorities.*') ? 'bg-gray-800' : '' }}">Priorities</a>
                            <a href="{{ route('admin.categories.index') }}" class="hover:bg-gray-700 px-3 py-2 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800' : '' }}">Categories</a>
                            <a href="{{ route('admin.labels.index') }}" class="hover:bg-gray-700 px-3 py-2 rounded {{ request()->routeIs('admin.labels.*') ? 'bg-gray-800' : '' }}">Labels</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.44l3.71-4.21a.75.75 0 011.08 1.04l-4.25 4.82a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-1 text-gray-900 z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">User Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
