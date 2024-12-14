@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mb-3 mt-4" style="max-width: 600px; margin: 0 auto; background-color: #ced4da; color: black;">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center text-black">New Booking</h3>
            <form action="{{ route('manageBooking.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="cust_name" class="font-weight-bold">Customer Name:</label>
                    <input 
                        type="text" 
                        name="cust_name" 
                        id="cust_name" 
                        class="form-control" 
                        placeholder="Enter customer's name" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="contact_number" class="font-weight-bold">Contact Number:</label>
                    <input 
                        type="text" 
                        name="contact_number" 
                        id="contact_number" 
                        class="form-control" 
                        placeholder="Enter contact number" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="event_date" class="font-weight-bold">Event Date:</label>
                    <input 
                        type="date" 
                        name="event_date" 
                        id="event_date" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="event_name" class="font-weight-bold">Event Name:</label>
                    <input 
                        type="text" 
                        name="event_name" 
                        id="event_name" 
                        class="form-control" 
                        placeholder="Enter event name" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="time" class="font-weight-bold">Time:</label>
                    <input 
                        type="time" 
                        name="time" 
                        id="time" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="item" class="font-weight-bold">Item:</label>
                    <textarea 
                        name="item" 
                        id="item" 
                        class="form-control" 
                        rows="5" 
                        placeholder="Enter item details" 
                        required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="notes" class="font-weight-bold">Notes:</label>
                    <textarea 
                        name="notes" 
                        id="notes" 
                        class="form-control" 
                        placeholder="Enter any additional notes (optional)"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Add Booking</button>
                    <a href="{{ route('manageBooking.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Outer Box Styles -->
<style>
    .outer-box {
        background-color: ##1c6dbd;
        padding: 20px; 
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
    .form-group label {
        font-size: 1rem;
    }
    .form-group {
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
