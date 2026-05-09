@extends('layouts.app')

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
    @foreach($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->supplier_name }}</td>
            <td>{{ $supplier->supplier_number }}</td>
            <td>{{ $supplier->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection