<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                class="block mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input 
                id="password" 
                name="password" 
                type="password" 
                required 
                autocomplete="current-password"
                class="block mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500"
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                >
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <!-- Password Reset + Login Button -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a 
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                    href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button 
                type="submit"
                class="ms-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>
