@extends('layouts.app')

@section('content')

<div class="form-container">

    <h2 class="page-title">Add Supply Item</h2>

    <form method="POST" action="{{ route('admin.items.store') }}">
        @csrf

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">-- Select Supplier --</option>

                @foreach(\App\Models\Supplier::all() as $supplier)
                    <option value="{{ $supplier->supplier_id }}">
                        {{ $supplier->supplier_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="item_name" required>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" step="0.01" value="0">
        </div>

        <div class="form-group">
        <label>Category</label>

        <select name="category" required>
            <option value="">-- Select Category --</option>

            <option value="Ingredient">
                Ingredient
            </option>

            <option value="Miscellaneous">
                Miscellaneous
            </option>
        </select>
        </div>
<button class="btn-submit full-width">Save Item</button>
</div>

@endsection