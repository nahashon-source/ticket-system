<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>My Tickets</h2>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->title }}</a></td>
                <td>{{ $ticket->priority->name }}</td>
                <td>{{ $ticket->status->name }}</td>
                <td>{{ $ticket->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $tickets->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
