@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Priority Details</h1>
        <a href="{{ route('admin.priorities.index') }}" class="btn btn-secondary">Back to Priorities</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Priority Information</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $priority->id }}</p>
            <p><strong>Name:</strong> {{ $priority->name }}</p>
            <p><strong>Created:</strong> {{ $priority->created_at->format('M d, Y H:i') }}</p>
            <p><strong>Last Updated:</strong> {{ $priority->updated_at->format('M d, Y H:i') }}</p>
            
            <div class="mt-3">
                <a href="{{ route('admin.priorities.edit', $priority) }}" class="btn btn-warning">Edit Priority</a>
                <form action="{{ route('admin.priorities.destroy', $priority) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this priority?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete Priority</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

