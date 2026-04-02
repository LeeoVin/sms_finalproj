@extends('layouts.app')

@section('title', 'Orders')
@section('headbar', 'Order History')

@section('content')
<div class="card">
    <div class="card-header">Orders List</div>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Supplier</th>
            <th>Employee</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->supplier->name }}</td>
            <td>{{ $order->employee->name }}</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>
            <td>{{ $order->status }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection