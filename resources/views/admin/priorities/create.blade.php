@extends('layouts.app')

@section('content')
<div class="container">
    <h1>New Priority</h1>

    <form action="{{ route('admin.priorities.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
