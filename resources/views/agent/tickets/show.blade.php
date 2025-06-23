@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    {{-- Ticket Details --}}
    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Ticket #{{ $ticket->id }} - {{ $ticket->title }}</h2>

        <p class="mb-2"><strong>Status:</strong> <span class="px-2 py-1 bg-gray-200 rounded">{{ $ticket->status->name }}</span></p>
        <p class="mb-2"><strong>Priority:</strong> <span class="px-2 py-1 bg-gray-200 rounded">{{ $ticket->priority->name }}</span></p>
        <p class="mb-2"><strong>Created At:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
        <p class="mb-2"><strong>Description:</strong></p>
        <div class="bg-gray-50 p-4 rounded mb-4">
            {{ $ticket->description }}
        </div>

        {{-- Optional: Back to tickets list --}}
        <a href="{{ route('agent.tickets.index') }}" class="text-blue-600 hover:underline">← Back to tickets</a>
    </div>

    {{-- Comments Section --}}
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Comments</h3>

        {{-- List of existing comments --}}
        @forelse($ticket->comments as $comment)
            <div class="border-b py-3">
                <p class="text-gray-800">{{ $comment->body }}</p>
                <div class="text-sm text-gray-500 mt-1">
                    By: {{ $comment->user->name ?? 'Unknown User' }} | {{ $comment->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="text-gray-500">No comments yet.</p>
        @endforelse

        {{-- New comment form --}}
        <form action="{{ route('agent.comments.store', $ticket->id) }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700">Add Comment</label>
                <textarea name="body" id="body" rows="3" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Post Comment</button>
        </form>
    </div>
</div>
@endsection
