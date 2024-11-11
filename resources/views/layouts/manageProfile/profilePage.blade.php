@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'user' && auth()->user()->role !='admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
<div class="container">
    <h2 class="mb-4">My Profile</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone No.:</strong> {{ $user->phoneNo }}</p>
            <p><strong>Position:</strong> {{ $user->position }}</p>
            <p><strong>Date of Birth:</strong> {{ $user->DOB }}</p>
            <a href="{{ route('manageProfile.edit', Auth::id()) }}" class="btn btn-primary mt-3">Edit Profile</a>

            {{-- Delete button --}}
            <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Account Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete your account? This action is irreversible and will permanently remove your account.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                
                <form action="{{ route('manageProfile.destroy', Auth::id()) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
