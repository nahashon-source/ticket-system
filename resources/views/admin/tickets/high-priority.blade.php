@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">High Priority Tickets</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>
                            @if($ticket->status)
                                <span class="badge bg-info">{{ $ticket->status->name }}</span>
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">No high priority tickets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
