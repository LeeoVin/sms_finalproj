@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')

<div class="card" style="max-width:500px; margin:auto;">

    <h2 style="margin-bottom:20px;">Add Supplier</h2>

    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:15px;">
            <label>Name</label>
            <input type="text" name="name" required style="width:100%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Contact</label>
            <input type="text" name="contact" required style="width:100%;">
        </div>

        <div style="margin-bottom:20px;">
            <label>Status</label>
            <select name="status" style="width:100%;">
                <option value="In Stock">In Stock</option>
                <option value="Out of Stock">Out of Stock</option>
            </select>
        </div>

        <button class="btn" style="width:100%;">Save Supplier</button>

    </form>

</div>

@endsection