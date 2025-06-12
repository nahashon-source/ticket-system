<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create a New Ticket</h4>
                </div>
                <div class="card-body">

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following issues:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="ticketForm">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input 
                                type="text"
                                name="title"
                                id="title"
                                class="form-control"
                                value="{{ old('title') }}"
                                required>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea 
                                name="description"
                                id="description"
                                class="form-control"
                                rows="4"
                                required>{{ old('description') }}</textarea>
                        </div>

                        {{-- Priority & Status --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select name="priority_id" id="priority_id" class="form-select" required>
                                    <option value="" disabled {{ old('priority_id') ? '' : 'selected' }}>Select priority</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                            {{ ucfirst($priority->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status_id" id="status_id" class="form-select" required>
                                    <option value="" disabled {{ old('status_id') ? '' : 'selected' }}>Select status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ ucfirst($status->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Assign To (Only for Admins) --}}
                        @if(auth()->user()->role === 'admin')
                            <div class="mb-3">
                                <label for="assigned_user_id" class="form-label">Assign To</label>
                                <select name="assigned_user_id" id="assigned_user_id" class="form-select">
                                    <option value="" disabled {{ old('assigned_user_id') ? '' : 'selected' }}>Select a user</option>
                                    @foreach ($users->where('role', 'agent') as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{-- Categories --}}
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories <span class="text-danger">*</span></label>
                            <select name="categories[]" id="categories" class="form-select" multiple required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Hold Ctrl (or Cmd) to select multiple categories.</small>
                        </div>

                        {{-- Labels --}}
                        <div class="mb-3">
                            <label for="labels" class="form-label">Labels <span class="text-danger">*</span></label>
                            <select name="labels[]" id="labels" class="form-select" multiple required>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ collect(old('labels'))->contains($label->id) ? 'selected' : '' }}>
                                        {{ $label->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Attach Files --}}
                        <div class="mb-4">
                            <label for="files" class="form-label">Attach Files</label>
                            <input 
                                type="file"
                                name="files[]"
                                id="files"
                                class="form-control"
                                multiple>
                            <div id="file-preview" class="mt-2"></div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                Submit Ticket
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@vite('resources/js/app.js')
</body>
</html>
