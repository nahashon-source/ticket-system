@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-6">Agent Dashboard</h2>

    <div class="flex space-x-4 mt-5">
        <a href="{{ route('agent.tickets.index') }}" 
           class="block bg-blue-600 text-white p-6 rounded-lg shadow w-1/3 hover:bg-blue-700 transition">
            <h3 class="text-lg font-semibold mb-2">Total Tickets</h3>
            <p class="text-4xl">{{ $ticketCount }}</p>
        </a>

        <a href="{{ route('agent.tickets.index', ['status' => 'Open']) }}" 
           class="block bg-yellow-500 text-white p-6 rounded-lg shadow w-1/3 hover:bg-yellow-600 transition">
            <h3 class="text-lg font-semibold mb-2">Open Tickets</h3>
            <p class="text-4xl">{{ $openCount }}</p>
        </a>

        <a href="{{ route('agent.tickets.index', ['status' => 'Closed']) }}" 
           class="block bg-green-600 text-white p-6 rounded-lg shadow w-1/3 hover:bg-green-700 transition">
            <h3 class="text-lg font-semibold mb-2">Closed Tickets</h3>
            <p class="text-4xl">{{ $closedCount }}</p>
        </a>
    </div>
</div>
@endsection
