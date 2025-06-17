@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Priority</h1>
        <a href="{{ route('admin.priorities.index') }}" class="btn btn-secondary">Back to Priorities</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.priorities.update', $priority) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $priority->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update Priority</button>
                    <div>
                        <a href="{{ route('admin.priorities.show', $priority) }}" class="btn btn-info">View Priority</a>
                        <a href="{{ route('admin.priorities.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
