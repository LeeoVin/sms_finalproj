@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

<h2>Suppliers</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Status</th>
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
        </tr>
    @empty
        <tr>
            <td colspan="3">No suppliers found</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection