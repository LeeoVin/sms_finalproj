@extends('layouts.app')

@section('content')

<h2>Supplies</h2>

<a href="{{ route('admin.items.create') }}" class="btn-add">+ Add Item</a>

<br><br>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th style="width:8%;">No.</th>
            <th style="width:22%;">Item Name</th>
            <th style="width:20%;">Supplier</th>
            <th style="width:15%;">Category</th>
            <th style="width:15%;">Price</th>
            <th style="width:15%;">Stock</th>
            <th style="width:20%; text-align:center;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($items as $item)
        <tr>
            <td>{{ $item->item_id }}</td>
            <td>{{ $item->item_name }}</td>

            <td>
                {{ $item->supplier->supplier_name ?? 'No Supplier' }}
            </td>
            <td>{{ $item->category ?? 'N/A' }}</td>
            <td>₱{{ number_format($item->price ?? 0, 2) }}</td>

            <td>
                {{ $item->branchStocks->sum('stock') ?? 0 }}
            </td>

            <td>
            <div class="action-buttons">
                <a href="{{ route('admin.items.edit', $item->item_id) }}" class="btn-edit">
                    Edit
                </a>

                <form method="POST" action="{{ route('admin.items.destroy', $item->item_id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete" onclick="return confirm('Delete item?')">
                        Delete
                    </button>
                </form>
            </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                No items found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection