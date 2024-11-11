<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
  // Display user's complaints  -- User
  public function index()
  {
    $userId = Auth::id();
    $datas = Complaint::where('user_id', $userId)->orderByRaw("FIELD(status,'In Progress','Pending','Resolved')")->paginate(8);
    return view('layouts.manageComplaint.complaintVenue',compact('datas'));
  }

  //Show the complaint form for submission -- User
  public function create()
  {
    return view('layouts.manageComplaint.complaintAddForm');
  }

  //Store the user's form data -- User
  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required|string',
      'description' => 'required|string',
    ]);

    Complaint::create([
      'user_id' => Auth::id(),
      'title' => $validated['title'],
      'description' => $validated['description'],
      'status' => 'Pending',
    ]);

    return redirect()->route('manageComplaint.index')
    ->with('success','Complaint Is Created! Thank you!');
  }

  //Admin && User
  public function destroy(Complaint $manageComplaint)
  {
    $manageComplaint->delete();
    return redirect()->route('manageComplaint.index')
    ->with('success','Complaint Is Deleted! Please submit again if necessary!');
  }

  //View all Complaints  -- Admin
  public function adminIndex()
  {
    $datas = Complaint::orderByRaw("FIELD(status,'In Progress','Pending','Resolved')")->paginate(8);
    return view('layouts.manageComplaint.adminComplaint', compact('datas'));
  }

  //Use for Update later -- since new page, not modal
  public function edit(Complaint $manageComplaint)
{
    return view('layouts.manageComplaint.adminStatusUpdate', compact('manageComplaint'));
}

  //Update the specific complaint's status  -- Admin
  public function update(Request $request, Complaint $manageComplaint)
  {
    //Action taken to incoming request data
    $validated = $request->validate([
      'status' => 'required|string|max:255',
    ]);

    //Update the Complaint's status
    $manageComplaint->update([
      'status' => $validated['status'],
    ]);

    return redirect()->route('manageComplaint.adminIndex')->with('success','Complaint status updated successfully!');
  }

  public function adminDestroy(Complaint $manageComplaint)
  {
    $manageComplaint->delete();
    return redirect()->route('manageComplaint.adminIndex')
    ->with('success','Complaint Is Successfully Deleted!');
  }
}
