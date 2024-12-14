@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card mb-3" style="max-width: 600px; margin: 0 auto; background-color: #ced4da; color: black;">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center text-black">Edit Booking</h3>
            <form action="{{ route('manageBooking.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="cust_name" class="font-weight-bold">Customer Name:</label>
                    <input 
                        type="text" 
                        name="cust_name" 
                        value="{{ $booking->cust_name }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="contact_number" class="font-weight-bold">Contact Number:</label>
                    <input 
                        type="text" 
                        name="contact_number" 
                        value="{{ $booking->contact_number }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="event_date" class="font-weight-bold">Event Date:</label>
                    <input 
                        type="date" 
                        name="event_date" 
                        value="{{ $booking->event_date }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="event_name" class="font-weight-bold">Event Name:</label>
                    <input 
                        type="text" 
                        name="event_name" 
                        value="{{ $booking->event_name }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="time" class="font-weight-bold">Time:</label>
                    <input 
                        type="time" 
                        name="time" 
                        value="{{ $booking->time }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="item" class="font-weight-bold">Item:</label>
                    <input 
                        type="text" 
                        name="item" 
                        value="{{ $booking->item }}" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="notes" class="font-weight-bold">Notes:</label>
                    <textarea 
                        name="notes" 
                        class="form-control">{{ $booking->notes }}</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('manageBooking.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
    .form-group {
        margin-bottom: 1.5rem; 
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-weight: bold;
    }
    .btn-secondary {
        font-weight: bold;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-secondary:hover {
        background-color: #6c757d;
        border-color: #5a6268;
    }
</style>
@endsection
