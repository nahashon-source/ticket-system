<!DOCTYPE html>
<html>
<head>
    <title>Edit Priority</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Priority</h2>

    <form action="{{ route('priorities.update', $priority->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Priority Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ $priority->name }}" required>

            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('priorities.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
