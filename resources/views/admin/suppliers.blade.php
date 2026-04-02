@extends('layouts.app')

@section('title', 'Suppliers')
@section('headbar', 'Supplier Management - Suppliers')

@section('content')
<div class="card">
    <div class="card-header">Suppliers List</div>
    <button class="btn" onclick="location.href='{{ route('admin.suppliers.create') }}'">Add Supplier</button>
    <table>
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->contact }}</td>
            <td>{{ $supplier->status }}</td>
            <td>
                <button class="btn" onclick="location.href='{{ route('admin.suppliers.edit', $supplier->id) }}'">Edit</button>
                <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection