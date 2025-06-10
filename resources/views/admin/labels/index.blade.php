<!DOCTYPE html>
<html>
<head>
    <title>Labels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Labels</h2>
    <a href="{{ route('labels.create') }}" class="btn btn-primary mb-3">Add Label</a>

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
        @foreach($labels as $label)
            <tr>
                <td>{{ $label->name }}</td>
                <td>{{ $label->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('labels.edit', $label->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('labels.destroy', $label->id) }}" method="POST" style="display:inline;">
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
