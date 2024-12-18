@extends('layouts.app')

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

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="unit_price" class="form-label">Unit Price (RM)</label>
                    <div class="input-group">
                        <span class="input-group-text">RM</span>
                        <input type="text" 
                               class="form-control @error('unit_price') is-invalid @enderror" 
                               id="unit_price" 
                               name="unit_price" 
                               value="{{ old('unit_price', number_format($stock->unit_price, 2)) }}"
                               placeholder="0.00"
                               required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="unit_type" class="form-label">Unit Type</label>
                    <select class="form-select @error('unit_type') is-invalid @enderror" 
                            id="unit_type" 
                            name="unit_type" 
                            required>
                        <option value="">Select unit type...</option>
                        <option value="unit" {{ old('unit_type', $stock->unit_type) == 'unit' ? 'selected' : '' }}>Unit</option>
                        <option value="kg" {{ old('unit_type', $stock->unit_type) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="g" {{ old('unit_type', $stock->unit_type) == 'g' ? 'selected' : '' }}>Gram (g)</option>
                        <option value="l" {{ old('unit_type', $stock->unit_type) == 'l' ? 'selected' : '' }}>Liter (L)</option>
                        <option value="ml" {{ old('unit_type', $stock->unit_type) == 'ml' ? 'selected' : '' }}>Milliliter (ml)</option>
                        <option value="box" {{ old('unit_type', $stock->unit_type) == 'box' ? 'selected' : '' }}>Box</option>
                        <option value="pack" {{ old('unit_type', $stock->unit_type) == 'pack' ? 'selected' : '' }}>Pack</option>
                    </select>
                    @error('unit_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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

    .input-group-text {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #343a40;
        font-weight: bold;
    }
</style>

<script>
    // Format unit price input to always show 2 decimal places
    document.getElementById('unit_price').addEventListener('blur', function(e) {
        const value = this.value.replace(/[^\d.]/g, '');
        if (value !== '') {
            this.value = parseFloat(value).toFixed(2);
        }
    });
</script>
@endsection