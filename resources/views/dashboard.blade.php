<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-semibold mb-6">Welcome, {{ Auth::user()->name }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-blue-600 text-white p-4 rounded shadow">
                    <h2 class="text-lg">Total Tickets</h2>
                    <p class="text-3xl font-bold">{{ $totalTickets ?? 0 }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded shadow">
                    <h2 class="text-lg">Open</h2>
                    <p class="text-3xl font-bold">{{ $openTickets ?? 0 }}</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded shadow">
                    <h2 class="text-lg">Resolved</h2>
                    <p class="text-3xl font-bold">{{ $resolvedTickets ?? 0 }}</p>
                </div>
                <div class="bg-gray-800 text-white p-4 rounded shadow">
                    <h2 class="text-lg">Closed</h2>
                    <p class="text-3xl font-bold">{{ $closedTickets ?? 0 }}</p>
                </div>
            </div>

            <a href="{{ route('tickets.create') }}" class="inline-block mb-6 px-5 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700">+ New Ticket</a>

            <div class="bg-white shadow rounded p-6">
                <h2 class="text-2xl font-semibold mb-4">Your Recent Tickets</h2>

                @if($recentTickets->isEmpty())
                    <p class="text-gray-500">No tickets found.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentTickets as $ticket)
                                <tr>
                                    <td class="px-6 py-4">{{ $ticket->title }}</td>
                                    <td class="px-6 py-4">{{ $ticket->status->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4">{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
