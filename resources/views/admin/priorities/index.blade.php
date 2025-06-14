@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Priorities</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.priorities.create') }}" class="btn btn-primary mb-3">New Priority</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($priorities as $priority)
                <tr>
                    <td>{{ $priority->name }}</td>
                    <td>
                        <a href="{{ route('admin.priorities.edit', $priority) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.priorities.destroy', $priority) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this priority?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No priorities yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
