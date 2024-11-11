@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'user'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-6">
        <h2><b>Complaint Venue</b></h2>
      </div>
      <div class="d-flex justify-content-end align-items-center">
        <a href="{{ route('manageComplaint.create') }}" class="btn btn-primary">Add</a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>Title</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($datas as $manageComplaint)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $manageComplaint->title }}</td>
                <td class="
                    @if ($manageComplaint->status == 'In Progress') text-warning
                    @elseif($manageComplaint->status == 'Resolved') text-success 
                    @elseif($manageComplaint->status == 'Pending') text-danger @endif">
                  <b>{{ $manageComplaint->status }}</b>
                </td>
                <td>
                  <form action="{{ route('manageComplaint.destroy',$manageComplaint) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div style="position: fixed; left: 50%; transform: translate(-50%, -50%);">
      @if (session('failure'))
        <div class="alert alert-danger">
          {{ session('failure') }}
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif
    </div>

    <div class="d-flex flex-row-reverse">
      {{ $datas->links('pagination::bootstrap-4') }}
    </div>
  </div>

  <script>
    // Automatically hide alert messages after 5 seconds
    setTimeout(function() {
      let alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        alert.classList.add('fade');
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 500); // Fully remove after fade-out
      });
    }, 5000);
  </script>

@endsection
