@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container mt-5">
    <div class="outer-box">
        <h2 class="mb-4">Stock List</h2>

        <!-- Search and Sort Bar -->
        <div class="d-flex justify-content-between mb-4">
            <div class="mr-2" style="margin-right: 10px;">
                <div class="input-group">
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
            </div>
            <div class="dropdown">
                <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'created_at', 'order' => 'asc']) }}" data-sort="created_at" data-order="asc">Added Date (Asc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'created_at', 'order' => 'desc']) }}" data-sort="created_at" data-order="desc">Added Date (Desc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'expiry_date', 'order' => 'asc']) }}" data-sort="expiry_date" data-order="asc">Expiry Date (Asc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'expiry_date', 'order' => 'desc']) }}" data-sort="expiry_date" data-order="desc">Expiry Date (Desc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'quantity', 'order' => 'asc']) }}" data-sort="quantity" data-order="asc">Stock (Asc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'quantity', 'order' => 'desc']) }}" data-sort="quantity" data-order="desc">Stock (Desc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'unit_price', 'order' => 'asc']) }}" data-sort="unit_price" data-order="asc">Unit Price (Asc)</a></li>
                    <li><a class="dropdown-item sort-link" href="{{ route('manageStock.index', ['sort' => 'unit_price', 'order' => 'desc']) }}" data-sort="unit_price" data-order="desc">Unit Price (Desc)</a></li>
                </ul>
            </div>
        </div>

        <!-- Stock List -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Unit Price (RM)</th>
                        <th class="text-center">Unit Type</th>
                        <th class="text-center">Expiry Date</th>
                        <th class="text-center">Added At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="stockTableBody">
                    @if($stocks->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No stocks found.</td>
                        </tr>
                    @else
                        @foreach($stocks as $stock)
                            @php
                                $expiryDate = $stock->expiry_date ? Carbon::parse($stock->expiry_date) : null;
                                $today = Carbon::now();
                                $daysUntilExpiry = $expiryDate ? $today->diffInDays($expiryDate, false) : null;
                                
                                $expiryClass = '';
                                if ($expiryDate) {
                                    if ($daysUntilExpiry < 0) {
                                        $expiryClass = 'expired';
                                    } elseif ($daysUntilExpiry <= 30) {
                                        $expiryClass = 'expiring-soon';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $stock->name }}</td>
                                <td class="text-center">
                                    {{ $stock->quantity }}
                                    @if($stock->quantity < $stock->min_quantity)
                                        <div class="low-stock-warning">
                                            <span class="badge bg-warning text-dark">Low Stock</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">RM {{ number_format($stock->unit_price, 2) }}</td>
                                <td class="text-center">{{ ucfirst($stock->unit_type) }}</td>
                                <td class="text-center {{ $expiryClass }}">
                                    <div class="expiry-container">
                                        <div class="expiry-date">
                                            @if($stock->expiry_date)
                                                {{ $expiryDate->format('d M Y') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </div>
                                        @if($stock->expiry_date)
                                            <div class="expiry-warning">
                                                @if($daysUntilExpiry < 0)
                                                    <span class="badge bg-danger">Expired {{ floor(abs($daysUntilExpiry)) }} days ago</span>
                                                @elseif($daysUntilExpiry <= 30)
                                                    <span class="badge bg-warning text-dark">Expires in {{ floor($daysUntilExpiry) }} days</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">{{ $stock->created_at->format('d M Y') }}</td>
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
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fas fa-info-circle fa-2x mb-3 text-info"></i>
                <h5>Are you sure want to delete?</h5>
                <p class="text-muted">This product will permanently delete from the stock list.</p>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary px-4">Yes</button>
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
        max-width: 1200px;
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
        font-size: 0.9rem;
    }

    .dropdown-menu {
        min-width: 8rem;
    }

    .expired {
        background-color: rgba(255, 0, 0, 0.1);
    }

    .expiring-soon {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }

    .expiry-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .expiry-date {
        font-weight: 500;
    }

    .expiry-warning {
        font-size: 0.85em;
    }

    .low-stock-warning {
        font-size: 0.85em;
    }

    /* Make table more compact on smaller screens */
    @media (max-width: 992px) {
        .table {
            font-size: 0.8rem;
        }
        .btn-custom {
            font-size: 0.8rem;
            padding: 0.375rem 0.5rem;
        }
    }

    /* Modal styles to match wireframe */
    .modal-content {
        border-radius: 15px;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body h5 {
        margin-bottom: 1rem;
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
            const unitType = row.cells[3].textContent.toLowerCase();
            const expiryDate = row.cells[4].textContent.toLowerCase();
            const addedAt = row.cells[5].textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || 
                unitType.includes(searchTerm) || 
                expiryDate.includes(searchTerm) ||
                addedAt.includes(searchTerm)) {
                row.style.display = '';
                stockFound = true;
            } else {
                row.style.display = 'none';
            }
        }

        if (!stockFound) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No stocks found.</td></tr>';
        }
    }

    function confirmDelete(id) {
        const modal = document.getElementById('deleteConfirmationModal');
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('manageStock') }}/${id}`;
        
        const deleteModal = new bootstrap.Modal(modal);
        deleteModal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sortLinks = document.querySelectorAll('.sort-link');

        sortLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const sort = this.dataset.sort;
                const order = this.dataset.order;
                const currentUrl = new URL(this.href);
                currentUrl.searchParams.set('order', order);
                this.href = currentUrl.toString();
                window.location.href = this.href;
            });
        });
    });
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