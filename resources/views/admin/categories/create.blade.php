<div class="max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6">New Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" required>
            @error('name') 
                <small class="text-red-500">{{ $message }}</small> 
            @enderror
        </div>

        <button type="submit"
                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded bg-indigo-600 text-white hover:bg-indigo-700">
            Create
        </button>
    </form>
</div>
