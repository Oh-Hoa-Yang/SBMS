@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
<div class="container">
    <h2>Update Complaint Status</h2>
    <form action="{{ route('manageComplaint.update', $manageComplaint->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Topic Title:</label>
            <p>{{ $manageComplaint->title }}</p>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <p>{{ $manageComplaint->description }}</p>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="">-- Select --</option>
                <option value="Pending" {{ $manageComplaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ $manageComplaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved" {{ $manageComplaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Confirm</button>
        <a href="{{ route('manageComplaint.adminIndex', $manageComplaint->id) }}" class="btn btn-secondary mt-2">Cancel</a>
    </form>
</div>
@endsection
