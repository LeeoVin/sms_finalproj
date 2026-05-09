@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')

<div class="form-container">

    <h2 class="page-title">Add Supplier</h2>

    <form method="POST" action="{{ route('admin.suppliers.store') }}">
        @csrf

        <div class="form-group">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="supplier_number" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="In Stock">In Stock</option>
                <option value="Out of Stock">Out of Stock</option>
            </select>
        </div>

        <button class="btn-submit full-width">Save Supplier</button>
    </form>

</div>

@endsection