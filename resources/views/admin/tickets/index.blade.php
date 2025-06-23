@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📋 All Tickets</h2>

    {{-- Success Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- If there are no tickets --}}
    @if($tickets->isEmpty())
        <div class="alert alert-info">No tickets found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Agent</th>
                        <th scope="col">Created</th>
                        <th scope="col">Actions</th>
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
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
