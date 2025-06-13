@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-lg-6">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <h5 class="mb-0">Edit Profile</h5>
            </div>

            <div class="card-body">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Status Message --}}
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Profile Update Form --}}
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    {{-- Name Field --}}
                    <div class="form-floating mb-3">
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', auth()->user()->name) }}" 
                            placeholder="Full Name"
                            required
                        >
                        <label for="name">Full Name</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="form-floating mb-4">
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email', auth()->user()->email) }}" 
                            placeholder="name@example.com"
                            required
                        >
                        <label for="email">Email address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
