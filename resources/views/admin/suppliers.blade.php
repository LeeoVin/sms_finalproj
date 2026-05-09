@extends('layouts.app')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2 style="margin:0;">Suppliers List</h2>
    <a href="{{ route('admin.suppliers.create') }}" class="btn-add">+ Add Supplier</a>
</div>

@if(session('success'))
    <div style="color: green; margin: 10px 0;">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th style="width:25%;">Name</th>
            <th style="width:25%;">Contact</th>
            <th style="width:20%;">Status</th>
            <th style="width:30%; text-align:center;">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->supplier_name }}</td>
            <td>{{ $supplier->supplier_number }}</td>

            <td>
                @if($supplier->status == 'Out of Stock')
                    <span style="color:red;">Out of Stock</span>
                @else
                    {{ $supplier->status }}
                @endif
            </td>

            <td>
            <div class="action-buttons">
                <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}" class="btn-edit">Edit</a>

                <form action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </div>                
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align:center;">No suppliers found</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection