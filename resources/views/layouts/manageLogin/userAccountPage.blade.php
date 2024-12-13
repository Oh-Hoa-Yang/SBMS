@extends('layouts.app')
@if (auth()->check() && auth()->user()->role != 'admin')
  {{ abort(403, 'Unauthorized action.') }}
@endif
@section('content')
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-6">
        <h2><b>User Account Records </b></h2>
      </div>


    <!-- Card Body -->
  <div class="card-body">
    <!-- Top Controls: Search Form and Add New User Button -->
    <div class="d-flex align-items-center mb-3">
        <!-- Search Form -->
        <form class="form-inline flex-grow-1" method="GET" action="{{ route('manageLogin.index') }}">
            <div class="input-group w-100">
                <input class="form-control" name="search" type="search" placeholder="Search by Name, Email, Phone No., Position, or Date of Birth" 
                       value="{{ request('search') }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>

        <!-- Add New User Button -->
        <a href="{{ route('manageLogin.create') }}" class="btn btn-success btn-sm ml-3" title="Add New User">
            <i class="fa fa-plus" aria-hidden="true"></i> Add
        </a>
    </div>
    
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>Position</th>
              <th>Date of Birth</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            {{-- Loop through each user in the $datas collection --}}
            @foreach ($datas as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phoneNo }}</td>
                <td>{{ $user->position }}</td>
                <td>{{ $user->DOB }}</td>

                <td class="d-grid gap-2 d-md-block">

                  <button onclick="location.href='{{ route('manageLogin.edit', $user->id) }}'" class="btn btn-info">
                    <i class="bi bi-pencil-fill"></i>
                  </button>

                  {{-- Use 'form' to delete the teacher account --}}
                  <form action="{{ route('manageLogin.destroy', $user->id) }}" class="d-inline-grid" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                  <button type="submit" class="btn btn-danger" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?')">
                       <i class="bi bi-trash-fill"></i> 
                  </button>
                  </form>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>

      {{-- Pagination links --}}
      <div class="d-flex flex-row-reverse">
        {{ $datas->links('pagination::bootstrap-4') }}
      </div>


      </tbody>
      </table>
    </div>

    {{-- Alert messages for success and failure --}}
    <div style="position: fixed; left: 50%; transform: translate(-50%, -50%);)">
      @if (session('failure'))
        <div class="alert alert-danger" role="alert">
          {{ session('failure') }}
        </div>
      @endif <!--Red pop up message-->

      @if (session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif <!--Green pop up message-->
    </div>
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
