@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.tickets.index') }}" class="text-white text-decoration-none" target="_blank">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Tickets</h5>
                        <h2 class="card-text">{{ $totalTickets ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('tickets.filter.status', 1) }}" class="text-white text-decoration-none" target="_blank">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Open Tickets</h5>
                        <h2 class="card-text">{{ $openTickets ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.tickets.highPriority') }}" class="text-white text-decoration-none" target="_blank">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">High Priority</h5>
                        <h2 class="card-text">{{ $highPriorityTickets ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        {{-- NEW Closed Tickets Card --}}
        <div class="col-md-3">
            <a href="{{ route('tickets.filter.status', $closedStatusId) }}" class="text-white text-decoration-none" target="_blank">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">Closed Tickets</h5>
                        <h2 class="card-text">{{ $closedTickets ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none" target="_blank">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Registered Users</h5>
                        <h2 class="card-text">{{ $userCount ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Recent Tickets</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTickets ?? [] as $ticket)
                            <tr>
                                <td>#{{ $ticket->id }}</td>
                                <td>{{ Str::limit($ticket->title, 50) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($ticket->status)
                                            @switch($ticket->status->name)
                                                @case('Open') bg-warning text-dark @break
                                                @case('Resolved') bg-success @break
                                                @case('Closed') bg-secondary @break
                                                @default bg-info
                                            @endswitch
                                        @else
                                            bg-secondary
                                        @endif">
                                        {{ $ticket->status->name ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary" target="_blank">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">No tickets found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
