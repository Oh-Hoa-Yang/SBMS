@extends('layouts.app')

@if (auth()->check() && auth()->user()->role != 'admin')
    {{ abort(403, 'Unauthorized action.') }}
@endif

@section('content')
<div class="container mt-5">
    <div class="outer-box">
        <h2 class="mb-4">Stock List</h2>

        <!-- Search Bar -->
        <div class="input-group mb-4">
            <input 
                type="text" 
                class="form-control" 
                id="searchInput" 
                placeholder="Search for stock..." 
                aria-label="Search" 
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-custom" type="button" onclick="searchStocks()">Search</button>
            </div>
        </div>

        <!-- Stock List -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="stockTableBody">
                    @if($stocks->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No stocks found.</td>
                        </tr>
                    @else
                        @foreach($stocks as $stock)
                            <tr>
                                <td>{{ $stock->name }}</td>
                                <td class="text-center">{{ $stock->quantity }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-custom dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('manageStock.edit', $stock->id) }}">Edit Stock</a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $stock->id }})">Delete Stock</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $stocks->links() }}
        </div>

        <!-- Add New Stock Button -->
        <div class="mt-4">
            <a href="{{ route('manageStock.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Stock
            </a>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete? This product will permanently delete from the stock list.
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .outer-box {
        background-color: #ced4da;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
        margin: 0 auto;
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

    .table {
        background-color: white;
        border-radius: 5px;
    }

    .dropdown-menu {
        min-width: 8rem;
    }
</style>

<!-- Scripts -->
<script>
    function searchStocks() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const tbody = document.getElementById('stockTableBody');
        const rows = tbody.getElementsByTagName('tr');
        let stockFound = false;

        for (let row of rows) {
            const productName = row.cells[0].textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                row.style.display = '';
                stockFound = true;
            } else {
                row.style.display = 'none';
            }
        }

        if (!stockFound) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">No stocks found.</td></tr>';
        }
    }

    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/manageStock/${id}`;
        
        const deleteModal = new bootstrap.Modal(modal);
        deleteModal.show();
    }
</script>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@endsection