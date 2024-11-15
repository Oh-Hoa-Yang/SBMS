@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'user' && auth()->user()->role !='admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
<div class="container">
    <h2 class="mb-4">Edit Profile</h2>
    <form action="{{ route('manageProfile.update',Auth::id()) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email', $user->email) }}" readonly>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="phoneNo" class="col-sm-2 col-form-label">Phone No.</label>
            <div class="col-sm-10">
                <input type="tel" class="form-control @error('phoneNo') is-invalid @enderror" id="phoneNo" name="phoneNo"
                       value="{{ old('phoneNo', $user->phoneNo) }}">
                @error('phoneNo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="position" class="col-sm-2 col-form-label">Position</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position"
                       value="{{ old('position', $user->position) }}">
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="DOB" class="col-sm-2 col-form-label">Date of Birth</label>
            <div class="col-sm-10">
                <input type="date" class="form-control @error('DOB') is-invalid @enderror" id="DOB" name="DOB"
                       value="{{ old('DOB', $user->DOB) }}">
                @error('DOB')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="password" class="col-sm-2 col-form-label">New Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
            </div>
        </div>
    </form>
</div>
@endsection
