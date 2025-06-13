@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Available Categories</h1>
    <ul class="list-group">
        @forelse ($categories as $category)
            <li class="list-group-item">{{ $category->name }}</li>
        @empty
            <li class="list-group-item">No categories available.</li>
        @endforelse
    </ul>
</div>
@endsection
