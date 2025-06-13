@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Labels</h1>
    <ul>
        @foreach ($labels as $label)
            <li>{{ $label->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
