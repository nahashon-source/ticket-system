@extends('layouts.app')

@section('title', 'Create Ticket')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Submit a New Support Ticket</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error messages --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded bg-red-100 text-red-800 border border-red-200">
            <h2 class="font-semibold mb-2">Please fix the following issues:</h2>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"/>
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" rows="4" required
                      class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('description') }}</textarea>
        </div>

        {{-- Priority & Status --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="priority_id" class="block text-sm font-medium text-gray-700">Priority <span class="text-red-500">*</span></label>
                <select id="priority_id" name="priority_id" required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="" disabled {{ old('priority_id') ? '' : 'selected' }}>Select priority</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                            {{ ucfirst($priority->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select id="status_id" name="status_id" required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="" disabled {{ old('status_id') ? '' : 'selected' }}>Select status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Assign to agent (admin only) --}}
        @if(auth()->user()->role === 'admin')
            <div>
                <label for="assigned_user_id" class="block text-sm font-medium text-gray-700">Assign To</label>
                <select id="assigned_user_id" name="assigned_user_id"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="" disabled {{ old('assigned_user_id') ? '' : 'selected' }}>Select an agent</option>
                    @foreach ($users->where('role', 'agent') as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- Categories --}}
        <div>
            <label for="categories" class="block text-sm font-medium text-gray-700">Categories <span class="text-red-500">*</span></label>
            <select id="categories" name="categories[]" multiple required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd) to select multiple.</p>
        </div>

        {{-- Labels --}}
        <div>
            <label for="labels" class="block text-sm font-medium text-gray-700">Labels <span class="text-red-500">*</span></label>
            <select id="labels" name="labels[]" multiple required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @foreach ($labels as $label)
                    <option value="{{ $label->id }}" {{ collect(old('labels'))->contains($label->id) ? 'selected' : '' }}>
                        {{ $label->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Attach Files --}}
        <div>
            <label for="files" class="block text-sm font-medium text-gray-700">Attach Files</label>
            <input type="file" id="files" name="files[]" multiple
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit"
                    class="inline-flex items-center justify-center w-full px-4 py-3 bg-indigo-600 text-white text-base font-medium rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Submit Ticket
            </button>
        </div>
    </form>
</div>
@endsection
