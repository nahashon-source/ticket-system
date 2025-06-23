@extends('layouts.agent')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Agent Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Tickets --}}
        <a href="{{ route('agent.tickets.index') }}" 
           class="flex flex-col items-center justify-center bg-blue-600 text-white p-6 rounded-lg shadow hover:bg-blue-700 transition duration-200">
            <div class="text-5xl mb-3">🎟️</div>
            <h3 class="text-lg font-semibold mb-1">Total Tickets</h3>
            <p class="text-3xl font-bold">{{ $ticketCount }}</p>
        </a>

        {{-- Open Tickets --}}
        <a href="{{ route('agent.tickets.filter.status', 'Open') }}" 
           class="flex flex-col items-center justify-center bg-yellow-500 text-white p-6 rounded-lg shadow hover:bg-yellow-600 transition duration-200">
            <div class="text-5xl mb-3">📬</div>
            <h3 class="text-lg font-semibold mb-1">Open Tickets</h3>
            <p class="text-3xl font-bold">{{ $openCount }}</p>
        </a>

        {{-- Closed Tickets --}}
        <a href="{{ route('agent.tickets.filter.status', 'Closed') }}" 
           class="flex flex-col items-center justify-center bg-green-600 text-white p-6 rounded-lg shadow hover:bg-green-700 transition duration-200">
            <div class="text-5xl mb-3">✅</div>
            <h3 class="text-lg font-semibold mb-1">Closed Tickets</h3>
            <p class="text-3xl font-bold">{{ $closedCount }}</p>
        </a>
    </div>
@endsection
