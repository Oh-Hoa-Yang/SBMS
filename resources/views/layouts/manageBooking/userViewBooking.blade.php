@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'user'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
<div class="container">
    <div class="outer-box mt-5">
        <h5 class="text-center font-weight-bold mb-4">Booking Details</h5>
        <p><strong>Customer Name:</strong> {{ $booking->cust_name }}</p>
        <p><strong>Contact Number:</strong> {{ $booking->contact_number }}</p>
        <p><strong>Event Date:</strong> {{ $booking->event_date }}</p>
        <p><strong>Event Name:</strong> {{ $booking->event_name }}</p>
        <p><strong>Time:</strong> {{ $booking->time }}</p>
        <p><strong>Item:</strong> {{ $booking->item }}</p>
        <p><strong>Notes:</strong> {{ $booking->notes }}</p>

        <!-- Buttons -->
        <div class="text-center mt-4">
            <a href="{{ route('manageBooking.edit', $booking->id) }}" class="btn btn-primary mr-2">Edit</a>
            <form action="{{ route('manageBooking.destroy', $booking->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
            </form>
            <a href="{{ route('manageBooking.index') }}" class="btn btn-secondary ml-2">Back to List</a>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .outer-box {
        background-color: #ced4da;
        border: 1px solid #ced4da; 
        border-radius: 10px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        padding: 20px; 
        max-width: 500px; 
        margin: 0 auto; 
    }

    h5 {
        color: #343a40; 
    }

    p {
        margin-bottom: 10px;
        font-size: 1rem; 
        color: #343a40; 
    }

    p strong {
        font-weight: bold;
        color: #495057; 
    }

    .btn-primary {
        background-color: #007bff; 
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-danger {
        background-color: #dc3545; 
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333; 
        border-color: #bd2130;
    }

    .btn-secondary {
        background-color: #6c757d; 
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .mr-2 {
        margin-right: 0.5rem;
    }

    .ml-2 {
        margin-left: 0.5rem;
    }
</style>
@endsection
