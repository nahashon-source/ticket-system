<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h1>
                    
                    @if(auth()->user()->role === 'admin')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h2 class="text-lg font-semibold text-blue-800 mb-2">Admin Dashboard</h2>
                            <p class="text-blue-700 mb-4">You have administrative privileges.</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="{{ route('tickets.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
                                    Manage All Tickets
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-center">
                                    Manage Categories
                                </a>
                                <a href="{{ route('admin.labels.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-center">
                                    Manage Labels
                                </a>
                            </div>
                        </div>
                    @elseif(auth()->user()->role === 'agent')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <h2 class="text-lg font-semibold text-green-800 mb-2">Agent Dashboard</h2>
                            <p class="text-green-700 mb-4">You can manage tickets assigned to you.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('tickets.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-center">
                                    View Assigned Tickets
                                </a>
                                <a href="{{ route('tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
                                    Create New Ticket
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">User Dashboard</h2>
                            <p class="text-gray-700 mb-4">Welcome to the support ticket system. You can create and view your tickets.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('tickets.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-center">
                                    View My Tickets
                                </a>
                                <a href="{{ route('tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
                                    Create New Ticket
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @php
                                $user = auth()->user();
                                if ($user->role === 'admin') {
                                    $totalTickets = \App\Models\Ticket::count();
                                    $openTickets = \App\Models\Ticket::whereHas('status', function($q) { $q->where('name', 'Open'); })->count();
                                } elseif ($user->role === 'agent') {
                                    $totalTickets = \App\Models\Ticket::where('assigned_user_id', $user->id)->count();
                                    $openTickets = \App\Models\Ticket::where('assigned_user_id', $user->id)->whereHas('status', function($q) { $q->where('name', 'Open'); })->count();
                                } else {
                                    $totalTickets = \App\Models\Ticket::where('user_id', $user->id)->count();
                                    $openTickets = \App\Models\Ticket::where('user_id', $user->id)->whereHas('status', function($q) { $q->where('name', 'Open'); })->count();
                                }
                                $categories = \App\Models\Category::count();
                                $labels = \App\Models\Label::count();
                            @endphp
                            
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-800">{{ $totalTickets }}</div>
                                <div class="text-blue-600">{{ $user->role === 'admin' ? 'Total Tickets' : ($user->role === 'agent' ? 'Assigned Tickets' : 'My Tickets') }}</div>
                            </div>
                            
                            <div class="bg-green-100 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-800">{{ $openTickets }}</div>
                                <div class="text-green-600">Open Tickets</div>
                            </div>
                            
                            <div class="bg-purple-100 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-purple-800">{{ $categories }}</div>
                                <div class="text-purple-600">Categories</div>
                            </div>
                            
                            <div class="bg-orange-100 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-orange-800">{{ $labels }}</div>
                                <div class="text-orange-600">Labels</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
