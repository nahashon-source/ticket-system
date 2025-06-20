@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-3xl font-semibold mb-6">Labels</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.labels.create') }}"
       class="inline-flex items-center px-4 py-2 mb-4 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
        + New Label
    </a>

    <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($labels as $label)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $label->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $label->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.labels.edit', $label->id) }}"
                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>

                            <form action="{{ route('admin.labels.destroy', $label->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this label?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No labels found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
