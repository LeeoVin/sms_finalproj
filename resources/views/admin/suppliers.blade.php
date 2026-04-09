@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h2>Suppliers</h2>

        <button class="btn"
            onclick="location.href='{{ route('admin.suppliers.create') }}'">
            + Add Supplier
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Status</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->contact }}</td>
                <td>{{ $supplier->status }}</td>

                <td style="text-align:center;">
                    <button class="btn"
                        onclick="location.href='{{ route('admin.suppliers.edit', $supplier->id) }}'">
                        Edit
                    </button>

                    <form method="POST"
                          action="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:20px;">
                    No suppliers found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection