<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
  // Show profile
  public function index()
  {
    $user = Auth::user();
    return view('layouts.manageProfile.profilePage', compact('user'));
  }

  // Show Form - Edit
  public function edit()
  {
    $user = Auth::user();
    return view('layouts.manageProfile.profileEditForm', compact('user'));
  }

  // Update profile
  public function update(Request $request)
  {
    /** @var \App\Models\User $user */

    $user = Auth::user();

    $validated = $request->validate([
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8|confirmed',
      'name' => 'nullable|string',
      'phoneNo' => 'nullable|string|max:10',
      'position' => 'nullable|string|max:225',
      'DOB' => 'nullable|date',
    ]);

    $user->update([
      'email' => $validated['email'],
      'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
      'name' => $validated['name'] ?? $user->name,
      'phoneNo' => $validated['phoneNo'] ?? $user->phoneNo,
      'position' => $validated['position'] ?? $user->position,
      'DOB' => $validated['DOB'] ?? $user->DOB,
    ]);

    return redirect()->route('manageProfile.index')->with('success', 'Profile updated successfully!');
  }

  // Delete profile
  public function destroy()
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->delete();
    Auth::logout();

    return redirect()->route('login')->with('success', 'Account deleted successfully!');
  }
}
