@extends('layouts.app')

@section('content')

<h2>Edit Supply</h2>

<form method="POST" action="{{ route('admin.items.update', $item->item_id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Item Name</label>
        <input type="text" name="item_name" value="{{ $item->item_name }}" required>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" step="0.01" value="{{ $item->price }}">
    </div>
    <div class="form-group">
    <label>Category</label>

    <select name="category" required>

        <option value="Ingredient"
            {{ $item->category == 'Ingredient' ? 'selected' : '' }}>
            Ingredient
        </option>

        <option value="Miscellaneous"
            {{ $item->category == 'Miscellaneous' ? 'selected' : '' }}>
            Miscellaneous
        </option>

    </select>
</div>

    <div class="form-group">
        <label>Supplier</label>
        <select name="supplier_id">
            @foreach(\App\Models\Supplier::all() as $supplier)
                <option value="{{ $supplier->supplier_id }}"
                    {{ $item->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>
                    {{ $supplier->supplier_name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn-submit">Update</button>
</form>

@endsection