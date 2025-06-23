<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Panel - @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-blue-800 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="flex items-center space-x-4">
            <a href="{{ route('agent.dashboard') }}" class="text-2xl font-semibold">Agent Panel</a>
            <a href="{{ route('agent.tickets.index') }}" class="hover:underline">Tickets</a>
            <a href="{{ route('profile.edit') }}" class="hover:underline">My Profile</a>
        </div>

        <div class="flex items-center space-x-4">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto mt-6">
        @yield('content')
    </main>

</body>
</html>
