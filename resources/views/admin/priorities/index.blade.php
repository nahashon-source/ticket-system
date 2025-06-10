<!DOCTYPE html>
<html>
<head>
    <title>Priorities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Priorities</h2>
    <a href="{{ route('priorities.create') }}" class="btn btn-primary mb-3">Add Priority</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($priorities as $priority)
            <tr>
                <td>{{ $priority->name }}</td>
                <td>{{ $priority->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('priorities.edit', $priority->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('priorities.destroy', $priority->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
