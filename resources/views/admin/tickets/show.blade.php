@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Ticket Details</h2>

    {{-- Ticket Info --}}
    <div class="mb-3">
        <strong>Title:</strong>
        <p class="form-control-plaintext">{{ $ticket->title }}</p>
    </div>

    <div class="mb-3">
        <strong>Description:</strong>
        <div class="border rounded p-3 bg-light">
            {{ $ticket->description }}
        </div>
    </div>

    <div class="mb-3">
        <strong>Status:</strong>
        <span class="badge 
            @if($ticket->status->name == 'Closed') bg-secondary 
            @elseif($ticket->status->name == 'Resolved') bg-success 
            @elseif($ticket->status->name == 'In Progress') bg-primary 
            @else bg-warning text-dark 
            @endif">
            {{ $ticket->status->name }}
        </span>
    </div>

    <div class="mb-3">
        <strong>Assigned Agent:</strong>
        <span class="text-muted">{{ $ticket->agent ? $ticket->agent->name : 'Unassigned' }}</span>
    </div>

    {{-- ✅ Status Update --}}
    @if(Auth::user()->role === 'admin')
    <div class="mb-3 mt-4">
        <h5>Update Status</h5>
        <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST" class="d-flex align-items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="status_id" class="form-select w-auto">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </form>
    </div>
    @endif
    {{-- ✅ Assign Agent --}}
@if(Auth::user()->role === 'admin')
    <div class="mb-3 mt-4">
        <h5>Assign Agent</h5>
        <form action="{{ route('admin.tickets.assignAgent', $ticket->id) }}" method="POST" class="d-flex gap-2">
            @csrf
            @method('PATCH')
            <select name="agent_id" class="form-select w-auto">
                <option value="">Unassigned</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success btn-sm">Assign</button>
        </form>
    </div>
@endif


 

    {{-- ✅ Back --}}
    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

</div>
@endsection
