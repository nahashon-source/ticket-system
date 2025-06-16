@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-blue-100 rounded">
            <h2 class="text-lg font-semibold">Total Tickets</h2>
            <p class="text-2xl">{{ $ticketCount }}</p>
        </div>
        <div class="p-4 bg-yellow-100 rounded">
            <h2 class="text-lg font-semibold">Open Tickets</h2>
            <p class="text-2xl">{{ $openTickets }}</p>
        </div>
        <div class="p-4 bg-orange-100 rounded">
            <h2 class="text-lg font-semibold">Pending Tickets</h2>
            <p class="text-2xl">{{ $pendingTickets }}</p>
        </div>
        <div class="p-4 bg-green-100 rounded">
            <h2 class="text-lg font-semibold">Closed Tickets</h2>
            <p class="text-2xl">{{ $closedTickets }}</p>
        </div>
        <div class="p-4 bg-purple-100 rounded col-span-4">
            <h2 class="text-lg font-semibold">Registered Users</h2>
            <p class="text-2xl">{{ $userCount }}</p>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-4">Recent Tickets</h2>
    <table class="table-auto w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Title</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentTickets as $ticket)
                <tr>
                    <td class="border px-4 py-2">{{ $ticket->id }}</td>
                    <td class="border px-4 py-2">{{ $ticket->title }}</td>
                    <td class="border px-4 py-2">{{ $ticket->status_id }}</td>
                    <td class="border px-4 py-2">{{ $ticket->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr>
                    <td class="border px-4 py-2 text-center" colspan="4">No tickets found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
