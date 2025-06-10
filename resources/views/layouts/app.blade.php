<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <!-- Navigation links here -->
        </nav>
    </header>

    <main>
        @yield('content') <!-- This is where ticket details will be inserted -->
    </main>

    <footer>
        <!-- Footer content here -->
    </footer>
</body>
</html>
