@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-semibold mb-6">Admin Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <a href="{{ route('admin.tickets.index') }}" target="_blank" class="bg-blue-600 text-white rounded-lg p-6 shadow hover:bg-blue-700 transition">
            <h5 class="text-lg font-medium">Total Tickets</h5>
            <p class="text-3xl mt-2">{{ $totalTickets ?? 0 }}</p>
        </a>

        <a href="{{ route('tickets.filter.status', 1) }}" target="_blank" class="bg-yellow-500 text-white rounded-lg p-6 shadow hover:bg-yellow-600 transition">
            <h5 class="text-lg font-medium">Open Tickets</h5>
            <p class="text-3xl mt-2">{{ $openTickets ?? 0 }}</p>
        </a>

        <a href="{{ route('admin.tickets.highPriority') }}" target="_blank" class="bg-cyan-600 text-white rounded-lg p-6 shadow hover:bg-cyan-700 transition">
            <h5 class="text-lg font-medium">High Priority</h5>
            <p class="text-3xl mt-2">{{ $highPriorityTickets ?? 0 }}</p>
        </a>

        <a href="{{ route('tickets.filter.status', $closedStatusId) }}" target="_blank" class="bg-gray-800 text-white rounded-lg p-6 shadow hover:bg-gray-900 transition">
            <h5 class="text-lg font-medium">Closed Tickets</h5>
            <p class="text-3xl mt-2">{{ $closedTickets ?? 0 }}</p>
        </a>
    </div>

    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" target="_blank" class="block bg-gray-700 text-white rounded-lg p-6 shadow hover:bg-gray-800 transition">
            <h5 class="text-lg font-medium">Registered Users</h5>
            <p class="text-3xl mt-2">{{ $userCount ?? 0 }}</p>
        </a>
    </div>

    <!-- Recent Tickets Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h5 class="text-lg font-medium">Recent Tickets</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($recentTickets ?? [] as $ticket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">#{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ Str::limit($ticket->title, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                    @switch(optional($ticket->status)->name)
                                        @case('Open') bg-yellow-100 text-yellow-800 @break
                                        @case('Resolved') bg-green-100 text-green-800 @break
                                        @case('Closed') bg-gray-300 text-gray-900 @break
                                        @default bg-blue-100 text-blue-800
                                    @endswitch">
                                    {{ $ticket->status->name ?? 'Unknown' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ticket->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
