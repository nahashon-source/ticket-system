<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Ticket Form -->
            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label for="files" class="form-label">Attach Files</label>
                    <input type="file" name="files[]" id="files" class="form-control" multiple>
                    <div id="file-preview" class="mt-2 d-flex flex-wrap"></div>
                </div>

                <!-- Priority -->
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" id="priority" class="form-select" required>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <!-- Assigned User -->
                <div class="mb-3">
                    <label for="assigned_user" class="form-label">Assigned User</label>
                    <select name="assigned_user" id="assigned_user" class="form-select" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Categories -->
                <div class="mb-3">
                    <label for="categories" class="form-label">Categories</label>
                    <select name="categories[]" id="categories" class="form-select" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Hold CTRL (or CMD) to select multiple.</small>
                </div>

                <!-- Labels -->
                <div class="mb-3">
                    <label for="labels" class="form-label">Labels</label>
                    <select name="labels[]" id="labels" class="form-select" multiple>
                        @foreach($labels as $label)
                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">Create Ticket</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- File Preview Script -->
<script>
    document.querySelector('#files').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('file-preview');
        previewContainer.innerHTML = '';
        [...event.target.files].forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'me-2', 'mb-2');
                    img.style.maxWidth = '100px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

</body>
</html>
