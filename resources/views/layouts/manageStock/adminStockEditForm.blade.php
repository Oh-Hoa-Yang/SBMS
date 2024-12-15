@extends('layouts.app')

@if (auth()->check() && auth()->user()->role != 'admin')
    {{ abort(403, 'Unauthorized action.') }}
@endif

@section('content')
<div class="container mt-5">
    <div class="outer-box">
        <h2 class="mb-4">Edit Stock</h2>

        <form action="{{ route('manageStock.update', $stock->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $stock->name) }}" 
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" 
                       class="form-control @error('quantity') is-invalid @enderror" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ old('quantity', $stock->quantity) }}"
                       required>
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" 
                       class="form-control @error('expiry_date') is-invalid @enderror" 
                       id="expiry_date" 
                       name="expiry_date" 
                       value="{{ old('expiry_date', $stock->expiry_date ? $stock->expiry_date->format('Y-m-d') : '') }}"
                       required>
                @error('expiry_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="sku" value="{{ $stock->sku }}">
            <input type="hidden" name="min_quantity" value="{{ $stock->min_quantity }}">
            <input type="hidden" name="unit_price" value="{{ $stock->unit_price }}">
            <input type="hidden" name="unit_type" value="{{ $stock->unit_type }}">
            <input type="hidden" name="active" value="{{ $stock->active }}">

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('manageStock.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-custom">Save</button>
            </div>
        </form>
    </div>
</div>

<style>
    .outer-box {
        background-color: #ced4da;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 600px;
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

    .form-control {
        background-color: white;
    }
</style>
@endsection