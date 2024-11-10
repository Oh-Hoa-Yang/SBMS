<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
  public function index()
  {
    $datas = User::where('role', 'user')->paginate(8);
    return view('layouts.manageLogin.userAccountPage', compact('datas'));
  }

  public function create()
  {
    return view('layouts.manageLogin.userAddForm');
  }

  public function store(Request $request)
  {
    //Validate the input data
    $validated = $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8|string',
      'name' => 'nullable|string|max:225',
      'phoneNo' => 'nullable|string|max:10',
      'position' => 'nullable|string|max:225',
      'DOB' => 'nullable|date|',
      'role' => 'required|string',
    ]);

    //Create the user after validation
    User::create([
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'name' => $validated['name'],
      'phoneNo' => $validated['phoneNo'],
      'position' => $validated['position'],
      'DOB' => $validated['DOB'],
      'role' => $validated['role'],
    ]);

    return redirect()->route('manageLogin.index')->with('success', 'User Account Is Added!');
  }

  public function edit(User $manageLogin)
  {
    return view('layouts.manageLogin.userEditForm', compact('manageLogin'));
  }

  public function update(Request $request, User $manageLogin)
  {
    $validated = $request->validate([
      'email' => 'required|email|unique:users,email,' . $manageLogin->id,
      'password' => 'required|string|min:8',
      'name' => 'nullable|string',
      'phoneNo' => 'nullable|string|max:10',
      'position' => 'nullable|string|max:225',
      'DOB' => 'nullable|date',
      'role' => 'required|string',
    ]);

    //Update the user's account with validated data
    $manageLogin->update([
      'email' => $validated['email'],
      'password' => $validated['password'] ? Hash::make($validated['password']) : $manageLogin->password,
      'name' => $validated['name'],
      'phoneNo' => $validated['phoneNo'],
      'position' => $validated['position'],
      'DOB' => $validated['DOB'],
      'role' => $validated['role'],
    ]);

    return redirect()->route('manageLogin.index')
      ->with('success', 'User Account Updated!');
  }

  public function destroy(User $manageLogin)
  {
    $manageLogin->delete();
    return redirect()->route('manageLogin.index')
      ->with('success', 'User Account Deleted!');
  }
}
