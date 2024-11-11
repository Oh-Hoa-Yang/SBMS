@extends('layouts.app')
@if (auth()->check() && (auth()->user()->role != 'admin'))
    {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-6">
        <h2><b>Complaints Management</b></h2>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($datas as $manageComplaint)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $manageComplaint->title }}</td>
              <td>{{ $manageComplaint->description }}</td>
              <td
                class="
                        @if ($manageComplaint->status == 'In Progress') text-warning
                        @elseif($manageComplaint->status == 'Resolved') text-success 
                        @elseif($manageComplaint->status == 'Pending') text-danger @endif">
                <b>{{ $manageComplaint->status }}</b>
              </td>
              <td>
                <a href="{{ route('manageComplaint.edit', $manageComplaint->id) }}" class="btn btn-success"><i class="bi bi-check-circle"></i></a>
                  <form action="{{ route('manageComplaint.adminDestroy',$manageComplaint->id)}}" class="d-inline-grid" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

   <div style="position: fixed; left: 50%; transform: translate(-50%, -50%);)">
      @if (session('failure'))
        <div class="alert alert-danger">
          {{ session('failure') }}
        </div>
      @endif <!--Red pop up message-->
  
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif <!--Green pop up message-->
    </div>

    <div class="d-flex flex-row-reverse">
      {{ $datas->links('pagination::bootstrap-4') }}
    </div>
  </div>

  <!-- Scripts -->
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
