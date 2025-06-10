<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticket Support System')</title>
    <!-- Tailwind CSS CDN (for quick styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Ticket System</h1>
            <div>
                <a href="/dashboard" class="text-blue-600 hover:underline mr-4">Dashboard</a>
                <a href="/categories" class="text-blue-600 hover:underline mr-4">Categories</a>
                <a href="/priorities" class="text-blue-600 hover:underline mr-4">Priorities</a>
                <a href="/users" class="text-blue-600 hover:underline mr-4">Users</a>
                <a href="/logs" class="text-blue-600 hover:underline">Logs</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4">
        @yield('content')
    </div>

    <footer class="text-center text-gray-500 mt-12 py-6 border-t">
        &copy; {{ date('Y') }} Ticket Support System
    </footer>

</body>
</html>
