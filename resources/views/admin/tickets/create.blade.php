@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">🎫 Create New Ticket</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some issues:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tickets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="agent_id" class="form-label">Assign To</label>
            <select name="agent_id" id="agent_id" class="form-select">
                <option value="">Select an agent</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Ticket</button>
    </form>
</div>
@endsection
