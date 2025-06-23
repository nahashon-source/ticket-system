@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Assigned Tickets</h2>

    @if($tickets->isEmpty())
        <p>No tickets assigned to you.</p>
    @else
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Priority</th>
                    <th class="px-4 py-2 border">Created</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td class="border px-4 py-2">{{ $ticket->id }}</td>
                        <td class="border px-4 py-2">{{ $ticket->title }}</td>
                        <td class="border px-4 py-2">{{ $ticket->status->name }}</td>
                        <td class="border px-4 py-2">{{ $ticket->priority->name }}</td>
                        <td class="border px-4 py-2">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="text-blue-600 underline">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
