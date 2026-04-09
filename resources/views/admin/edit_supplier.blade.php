@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<div class="card" style="max-width:500px; margin:auto;">

    <h2 style="margin-bottom:20px;">Edit Supplier</h2>

    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label>Name</label>
            <input type="text" name="name" value="{{ $supplier->name }}" required style="width:100%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Contact</label>
            <input type="text" name="contact" value="{{ $supplier->contact }}" required style="width:100%;">
        </div>

        <div style="margin-bottom:20px;">
            <label>Status</label>
            <select name="status" style="width:100%;">
                <option value="In Stock" {{ $supplier->status=='In Stock'?'selected':'' }}>In Stock</option>
                <option value="Out of Stock" {{ $supplier->status=='Out of Stock'?'selected':'' }}>Out of Stock</option>
            </select>
        </div>

        <button class="btn" style="width:100%;">Update Supplier</button>

    </form>

</div>

@endsection