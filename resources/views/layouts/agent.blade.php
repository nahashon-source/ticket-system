<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent Panel | Ticket System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- Navigation Bar --}}
    <nav class="bg-blue-600 text-white px-4 py-3 shadow sticky top-0 z-50">
        <div class="container mx-auto flex flex-wrap justify-between items-center">
            <h1 class="text-xl font-bold">🎛️ Agent Panel</h1>

            <div class="space-x-6 text-sm font-medium">
                <a href="{{ route('agent.dashboard') }}" 
                   class="hover:underline hover:text-blue-200 transition">📊 Dashboard</a>

                <a href="{{ route('agent.tickets.index') }}" 
                   class="hover:underline hover:text-blue-200 transition">🎟️ My Tickets</a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="hover:underline hover:text-blue-200 transition">🚪 Logout</a>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container mx-auto px-4 py-6">
        @yield('content')
    </div>

    {{-- Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</body>
</html>
