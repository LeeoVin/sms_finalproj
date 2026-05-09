@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<h2>Edit Supplier</h2>

<form method="POST" action="{{ route('admin.suppliers.update', $supplier->supplier_id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Supplier Name</label>
        <input type="text" name="supplier_name" value="{{ $supplier->supplier_name }}" required>
    </div>

    <div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="supplier_number" value="{{ $supplier->supplier_number }}" required>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status">
            <option value="In Stock" {{ $supplier->status == 'In Stock' ? 'selected' : '' }}>
                In Stock
            </option>
            <option value="Out of Stock" {{ $supplier->status == 'Out of Stock' ? 'selected' : '' }}>
                Out of Stock
            </option>
        </select>
    </div>

    <button type="submit" class="btn-submit">Update Supplier</button>

</form>

@endsection