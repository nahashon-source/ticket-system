<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">

<div class="container py-5">
    <header class="mb-4">
        <h1 class="mb-3">🎫 Ticketing System</h1>
        <nav class="mb-3">
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary btn-sm me-2">All Tickets</a>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">Create Ticket</a>
        </nav>
    </header>

    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="mb-0">Create a New Ticket</h2>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following issues:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
    @csrf

    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Enter ticket title" value="{{ old('title') }}" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Provide details about the issue" required>{{ old('description') }}</textarea>
    </div>

    <!-- File Upload -->
    <div class="mb-3">
        <label for="files" class="form-label">Attach Files</label>
        <input type="file" name="files[]" id="files" class="form-control" multiple>
        <div id="file-preview" class="mt-3 d-flex flex-wrap"></div>
    </div>

    <!-- Priority -->
    <div class="mb-3">
        <label for="priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
        <select name="priority_id" id="priority_id" class="form-select" required>
            <option value="" selected disabled>Choose priority</option>
            @foreach($priorities as $priority)
                <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                    {{ $priority->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status_id" id="status_id" class="form-select" required>
            <option value="" selected disabled>Choose status</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Assigned User -->
    <div class="mb-3">
        <label for="assigned_user_id" class="form-label">Assigned User <span class="text-danger">*</span></label>
        <select name="assigned_user_id" id="assigned_user_id" class="form-select" required>
            <option value="" selected disabled>Select user</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Categories -->
    <div class="mb-3">
        <label for="categories" class="form-label">Categories</label>
        <select name="categories[]" id="categories" class="form-select" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Hold CTRL (or CMD) to select multiple.</small>
    </div>

    <!-- Labels -->
    <div class="mb-3">
        <label for="labels" class="form-label">Labels</label>
        <select name="labels[]" id="labels" class="form-select" multiple>
            @foreach($labels as $label)
                <option value="{{ $label->id }}" {{ collect(old('labels'))->contains($label->id) ? 'selected' : '' }}>
                    {{ $label->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Submit and Reset -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success" id="submitBtn">Create Ticket</button>
        <button type="reset" class="btn btn-outline-secondary">Clear Form</button>
    </div>
</form>

        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- File Preview Script -->
<script>
    const fileInput = document.getElementById('files');
    const previewContainer = document.getElementById('file-preview');

    fileInput.addEventListener('change', () => {
        previewContainer.innerHTML = '';
        [...fileInput.files].forEach(file => {
            const isImage = file.type.startsWith('image/');
            const previewElement = document.createElement(isImage ? 'img' : 'span');

            if (isImage) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewElement.src = e.target.result;
                    previewElement.className = 'img-thumbnail me-2 mb-2';
                    previewElement.style.maxWidth = '100px';
                    previewContainer.appendChild(previewElement);
                };
                reader.readAsDataURL(file);
            } else {
                previewElement.className = 'badge bg-secondary me-2 mb-2';
                previewElement.textContent = file.name;
                previewContainer.appendChild(previewElement);
            }
        });
    });

    // Prevent multiple form submissions
    document.getElementById('ticketForm').addEventListener('submit', () => {
        document.getElementById('submitBtn').disabled = true;
    });
</script>

</body>
</html>
