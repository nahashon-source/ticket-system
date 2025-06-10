<!DOCTYPE html>
<html>
<head>
    <title>Create Priority</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Priority</h2>

    <form action="{{ route('priorities.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Priority Name</label>
            <input type="text" name="name" id="name" class="form-control" required>

            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('priorities.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
