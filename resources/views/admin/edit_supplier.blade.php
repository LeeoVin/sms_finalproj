@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('headbar', 'Supplier Management - Edit Supplier')

@section('content')
<div class="card">
    <div class="card-header">Edit Supplier</div>
    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ $supplier->name }}" required style="padding:0.5rem; width:100%; margin-bottom:1rem;">
        </div>
        <div>
            <label>Contact:</label>
            <input type="text" name="contact" value="{{ $supplier->contact }}" required style="padding:0.5rem; width:100%; margin-bottom:1rem;">
        </div>
        <div>
            <label>Status:</label>
            <select name="status" style="padding:0.5rem; width:100%; margin-bottom:1rem;">
                <option value="In Stock" {{ $supplier->status=='In Stock'?'selected':'' }}>In Stock</option>
                <option value="Out of Stock" {{ $supplier->status=='Out of Stock'?'selected':'' }}>Out of Stock</option>
            </select>
        </div>
        <button class="btn" type="submit">Update Supplier</button>
    </form>
</div>
@endsection