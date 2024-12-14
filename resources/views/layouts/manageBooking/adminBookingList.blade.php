@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
<div class="container mt-5">
    <div class="outer-box">
        <h2 class="mb-4">Booking List</h2>

        <!-- Search Bar -->
        <div class="input-group mb-4">
            <input 
                type="text" 
                class="form-control" 
                id="searchInput" 
                placeholder="Search for booking..." 
                aria-label="Search" 
                aria-describedby="basic-addon2" 
                value="{{ request()->input('search_term') }}">
            <div class="input-group-append">
                <button class="btn btn-custom" type="button" onclick="searchBookings()">Search</button>
            </div>
        </div>

        <!-- Search Results -->
        <h3 class="mb-3">Confirmed Booking</h3>
        <div class="list-group" id="userBookingList">
            @if ($bookings->count() === 0)
                <p>No data found.</p>
            @else
                @foreach ($bookings as $booking)
                    <a 
                        href="{{ route('manageBooking.display', ['id' => $booking->id]) }}" 
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $booking->event_name }}
                        <span class="badge badge-custom">{{ $booking->event_date }}</span>
                    </a>
                @endforeach
            @endif
        </div>

        <!-- Alert for No Results -->
        <div class="alert alert-danger mt-3" role="alert" id="notFoundAlert" style="display: none;">
            No booking found.
        </div>

        <!-- Button to Create New Booking -->
        <div class="mt-4">
            <a href="{{ route('manageBooking.create') }}" class="btn btn-success">New Booking</a>
        </div>
    </div>
</div>

<!-- Outer Box Styles -->
<style>
    .outer-box {
        background-color: #ced4da; 
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        margin: 0 auto; 
    }

    .badge-custom {
        background-color: #f8f9fa;
        color: #343a40; 
        border: 1px solid #6c757d; 
        border-radius: 5px;
        padding: 0.25em 0.75em;
        font-size: 0.9rem;
    }

    .btn-custom {
        background-color: #ffc107; 
        border-color: #ffc107;
        color: #343a40; 
        font-weight: bold;
    }

    .btn-custom:hover {
        background-color: #e0a800; 
        border-color: #d39e00;
    }

    .input-group-append {
        display: flex;
        align-items: center;
    }
</style>

<!-- Custom Scripts -->
<script>
    function searchBookings() {
        var searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        var bookingList = document.getElementById('userBookingList');
        var bookings = bookingList.getElementsByClassName('list-group-item');
        var bookingFound = false;

        for (var i = 0; i < bookings.length; i++) {
            var bookingName = bookings[i].textContent.toLowerCase();

            if (bookingName.includes(searchTerm)) {
                bookings[i].style.display = "flex"; 
                bookingFound = true;
            } else {
                bookings[i].style.display = "none"; 
            }
        }

        var notFoundAlert = document.getElementById('notFoundAlert');
        if (bookingFound) {
            notFoundAlert.style.display = "none";
        } else {
            notFoundAlert.style.display = "block";
        }
    }
</script>
@endsection
