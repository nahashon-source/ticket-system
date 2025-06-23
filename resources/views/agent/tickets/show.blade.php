@extends('layouts.agent')

@section('content')
<div class="container mx-auto py-8 max-w-4xl">

    {{-- Ticket Details --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-8">
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">🎟️ Ticket #{{ $ticket->id }} — {{ $ticket->title }}</h2>
        </div>

        <div class="p-6 space-y-4 text-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>Status:</strong>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded">{{ $ticket->status->name }}</span>
                </p>
                <p><strong>Priority:</strong>
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded">{{ $ticket->priority->name }}</span>
                </p>
                <p><strong>Created:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-800 mb-2">Description:</p>
                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                    {{ $ticket->description }}
                </div>
            </div>

            <div>
                <a href="{{ route('agent.tickets.index') }}" class="text-blue-600 hover:underline text-sm">← Back to Tickets</a>
            </div>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="border-b px-6 py-4 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-800">💬 Comments</h3>
        </div>

        <div class="p-6">
            {{-- Existing comments --}}
            @forelse($ticket->comments as $comment)
                <div class="py-4">
                    <p class="text-gray-800 mb-1">{{ $comment->body }}</p>
                    <div class="text-sm text-gray-500">
                        By <span class="font-medium text-gray-700">{{ $comment->user->name ?? 'Unknown User' }}</span>
                        &middot; {{ $comment->created_at->diffForHumans() }}
                    </div>
                </div>
                @unless($loop->last)
                    <hr class="my-3 border-gray-200">
                @endunless
            @empty
                <p class="text-gray-500">No comments yet.</p>
            @endforelse

            {{-- New comment form --}}
            <form action="{{ route('agent.comments.store', $ticket->id) }}" method="POST" class="mt-8">
                @csrf
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Add a Comment</label>
                    <textarea name="body" id="body" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-gray-800" placeholder="Write your comment here..." required></textarea>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Post Comment
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
