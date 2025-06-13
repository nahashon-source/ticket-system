@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Priorities</h1>
    <ul>
        @foreach ($priorities as $priority)
            <li>{{ $priority->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
