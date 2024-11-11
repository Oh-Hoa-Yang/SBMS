@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'user'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col text-center text-warning-emphasis">
        <h2 class="text-warning-emphasis"><b>SBMS Complaint Add Form</b></h2>
        <hr>
        <hr>
        <hr>
      </div>
    </div>

    <form action="{{ route('manageComplaint.store') }}" method="POST">
      @csrf
      <div class="card row d-flex justify-content-center align-items-center">
        <div class="col-md-6">
          <div class="form-group row m-3">
            <label for="title" class="col-sm-4 col-form-label">Topic Title</label>
            <div class="col-sm-8">
              <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title') }}">
              @error('title')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="description" class="col-sm-4 col-form-label">Description</label>
            <div class="col-sm-8">
              <input type="description" class="form-control @error('description') is-invalid @enderror" id="description"
                name="description" value="{{ old('description') }}">
              @error('description')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          
        <br><br><br>
        <div class="row justify-content-center">
          <div class="col-md-2">
            <div class="col d-flex text-center m-4">
              <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Cancel</button>
              <button type="submit" class="btn btn-primary ms-3">Submit</button>
            </div>
          </div>
        </div>
        <br><br>
      </div>
    </form>
  </div>
@endsection
