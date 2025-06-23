<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">🎟️ My Tickets</h2>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Ticket</a>
    </div>

    @if($tickets->isEmpty())
        <div class="alert alert-info">
            You have not raised any tickets yet.
        </div>
    @else
        <div class="table-responsive bg-white rounded shadow-sm p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr class="align-middle">
                        <td>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-decoration-none text-primary fw-semibold">
                                {{ $ticket->title }}
                            </a>
                        </td>
                        <td>
                            @php
                                $priorityColors = [
                                    'High' => 'danger',
                                    'Medium' => 'warning',
                                    'Low' => 'success'
                                ];
                            @endphp
                            <span class="badge bg-{{ $priorityColors[$ticket->priority->name] ?? 'secondary' }}">
                                {{ $ticket->priority->name }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'Open' => 'primary',
                                    'In Progress' => 'warning',
                                    'Closed' => 'success'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$ticket->status->name] ?? 'secondary' }}">
                                {{ $ticket->status->name }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4" aria-label="Pagination">
            {{ $tickets->links() }}
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
