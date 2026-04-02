@extends('layouts.app')

@section('title', 'Add Supplier')
@section('headbar', 'Supplier Management - Add Supplier')

@section('content')
<div class="card">
    <div class="card-header">Add New Supplier</div>
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" required style="padding:0.5rem; width:100%; margin-bottom:1rem;">
        </div>
        <div>
            <label>Contact:</label>
            <input type="text" name="contact" required style="padding:0.5rem; width:100%; margin-bottom:1rem;">
        </div>
        <div>
            <label>Status:</label>
            <select name="status" style="padding:0.5rem; width:100%; margin-bottom:1rem;">
                <option value="In Stock">In Stock</option>
                <option value="Out of Stock">Out of Stock</option>
            </select>
        </div>
        <button class="btn" type="submit">Save Supplier</button>
    </form>
</div>
@endsection