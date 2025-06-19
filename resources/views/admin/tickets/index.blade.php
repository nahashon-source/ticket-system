@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Tickets</h2>

    {{-- Success Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- If there are no tickets --}}
    @if($tickets->isEmpty())
        <div class="alert alert-info">No tickets found.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Agent</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>
                            <span class="badge 
                                @if($ticket->status->name == 'Closed') bg-secondary 
                                @elseif($ticket->status->name == 'Resolved') bg-success 
                                @elseif($ticket->status->name == 'In Progress') bg-primary 
                                @else bg-warning text-dark 
                                @endif">
                                {{ $ticket->status->name }}
                            </span>
                        </td>
                        <td>{{ $ticket->agent ? $ticket->agent->name : 'Unassigned' }}</td>
                        <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
