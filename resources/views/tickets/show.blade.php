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

    {{-- ✅ Comments Section --}}
    <div class="mt-5">
        <h4>Comments</h4>

        @forelse($ticket->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <strong>{{ $comment->user->name }}</strong>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    <p class="mt-2">{{ $comment->body }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">No comments yet.</p>
        @endforelse

        {{-- Add New Comment --}}
        <h5 class="mt-4">Add a Comment</h5>
        <form action="{{ route('comments.store', $ticket) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="body" rows="3" class="form-control" placeholder="Write your comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-secondary mt-4">Back to Tickets</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
