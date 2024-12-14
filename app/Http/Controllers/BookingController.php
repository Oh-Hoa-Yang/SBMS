<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
{
    $userId = Auth::id();
    $userRole = Auth::user()->role; // Assuming 'role' is a column in the 'users' table

    if ($userRole === 'user') {
        // Fetch bookings for the authenticated user
        $bookings = Booking::where('user_id', $userId)->get();
        return view('layouts.manageBooking.userBookingList', compact('bookings'));
    } elseif ($userRole === 'admin') {
        // Fetch all bookings for the admin
        $bookings = Booking::all();
        return view('layouts.manageBooking.adminBookingList', compact('bookings'));
    } else {
        // Redirect or abort for unexpected roles
        abort(403, 'Unauthorized action.');
    }
}

    public function create()
    {
        $userId = Auth::id();
        $bookings = Booking::where('user_id', $userId)->get();
        return view('layouts.manageBooking.userAddBooking', compact('bookings'));
    }
    public function display($id)
    {
        $booking = Booking::findOrFail($id); // Fetch a single booking by ID
        $userRole = Auth::user()->role; // Assuming 'role' is a column in the 'users' table
    
        if ($userRole === 'user') {
            // Ensure the user can only view their own bookings
            if ($booking->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.'); // Prevent access to others' bookings
            }
            return view('layouts.manageBooking.userViewBooking', compact('booking'));
        } elseif ($userRole === 'admin') {
            // Admin can view all bookings
            return view('layouts.manageBooking.adminViewBooking', compact('booking'));
        } else {
            // Handle unexpected roles
            abort(403, 'Unauthorized action.');
        }
    }
    


    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('layouts.manageBooking.userEditBooking', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cust_name' => 'required|string',
            'contact_number' => 'required|string',
            'event_date' => 'required|date',
            'event_name' => 'required|string',
            'time' => 'required',
            'item' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('manageBooking.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('manageBooking.index')->with('success', 'Booking deleted successfully!');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'cust_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'event_date' => 'required|date',
            'event_name' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
            'item' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Store the data in the database
        Booking::create([
            'cust_name' => $request->cust_name,
            'contact_number' => $request->contact_number,
            'event_date' => $request->event_date,
            'event_name' => $request->event_name,
            'time' => $request->time,
            'item' => $request->item,
            'notes' => $request->notes,
            'user_id' => Auth::id(),
        ]);

        // Redirect to a confirmation page or back to the booking list
        return redirect()->route('manageBooking.index')->with('success', 'Booking added successfully.');
    }




}
