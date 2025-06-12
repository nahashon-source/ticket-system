<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Ticket System</title>

    <!-- Vite CSS/JS compiled with Bootstrap & Alpine -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bg-primary text-white p-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Ticketing System</h1>
            <nav>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-light me-2">All Tickets</a>
                <a href="{{ route('tickets.create') }}" class="btn btn-light">Create Ticket</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
