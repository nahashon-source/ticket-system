@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Details</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>User Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> 
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                    <p><strong>Registered:</strong> {{ $user->created_at->format('M d, Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}</p>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit User</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete User</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>User's Tickets ({{ $user->tickets->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($user->tickets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->tickets as $ticket)
                                        <tr>
                                            <td>#{{ $ticket->id }}</td>
                                            <td>{{ Str::limit($ticket->title, 30) }}</td>
                                            <td>
                                                @if($ticket->status)
                                                    <span class="badge bg-info">{{ $ticket->status->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ticket->priority)
                                                    <span class="badge bg-warning">{{ $ticket->priority->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">None</span>
                                                @endif
                                            </td>
                                            <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">This user hasn't created any tickets yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

