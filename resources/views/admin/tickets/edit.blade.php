@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Ticket</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tickets.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="agent_id">Assign To</label>
            <select name="agent_id" id="agent_id" class="form-control">
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


{{-- resources/views/admin/tickets/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Ticket</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $ticket->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $ticket->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="agent_id">Assign To</label>
            <select name="agent_id" id="agent_id" class="form-control">
                <option value="">Select an agent</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" {{ old('agent_id', $ticket->agent_id) == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Ticket</button>
    </form>
</div>
@endsection
