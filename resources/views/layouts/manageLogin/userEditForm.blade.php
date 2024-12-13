@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col text-center text-warning-emphasis">
        <h2 class="text-warning-emphasis"><b>SBMS User Accounts Edit Form</b></h2>
        <hr>
        <hr>
        <hr>
      </div>
    </div>

    <form action="{{ route('manageLogin.update', $manageLogin->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="card row d-flex justify-content-center align-items-center">
        <div class="col-md-6">
          <div class="form-group row m-3">
            <label for="name" class="col-sm-4 col-form-label">Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $manageLogin->name) }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="email" class="col-sm-4 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $manageLogin->email) }}">
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="password" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password">
                <p style="font-style: italic" class="text-warning-emphasis">Please fill it again, this is the privacy of the user</p>
              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="phoneNo" class="col-sm-4 col-form-label">Phone No.</label>
            <div class="col-sm-8">
              <input type="tel" class="form-control @error('phoneNo') is-invalid @enderror" id="phoneNo"
                name="phoneNo" value="{{ old('phoneNo', $manageLogin->phoneNo) }}">
              @error('phoneNo')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="position" class="col-sm-4 col-form-label">Position</label>
            <div class="col-sm-8">
              <input type="text" class="form-control @error('position') is-invalid @enderror" id="position"
                name="position" value="{{ old('position', $manageLogin->position) }}">
              @error('position')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="DOB" class="col-sm-4 col-form-label">Date of Birth</label>
            <div class="col-sm-8">
              <input type="date" class="form-control @error('DOB') is-invalid @enderror" id="DOB"
                name="DOB" value="{{ old('DOB', $manageLogin->DOB) }}">
              @error('DOB')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="role" class="col-sm-4 col-form-label">Role</label>
            <div class="col-sm-8">
              <select name="role" id="role" class="form-select @error('role') is-invalid @enderror"
                aria-label="role">
                <option value="user" {{ old('role', $manageLogin->role) == 'user' ? 'selected' : '' }}>User</option>
              </select>
              @error('role')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
        </div>
        <br><br><br>
        <div class="row justify-content-center">
          <div class="col-md-2">
            <div class="col d-flex text-center m-4">
              <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Cancel</button>
              <button type="submit" class="btn btn-primary ms-3" onclick="return confirm('Are you sure you want to save these changes?')">Submit</button>
            </div>
          </div>
        </div>
        <br><br>
      </div>
    </form>
  </div>
@endsection
