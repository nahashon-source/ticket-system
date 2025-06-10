<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-3">Ticket #{{ $ticket->id }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $ticket->title }}</h5>
            <p class="card-text">{{ $ticket->description }}</p>
            <p><strong>Priority:</strong> {{ ucfirst($ticket->priority->name) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($ticket->status->name) }}</p>
        </div>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
