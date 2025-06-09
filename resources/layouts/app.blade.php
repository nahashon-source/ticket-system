<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Ticket System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
