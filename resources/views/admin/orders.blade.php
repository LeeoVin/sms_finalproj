@extends('layouts.app')

@section('content')

<h2>All Orders</h2>

<table>
    <thead>
        <tr>
            <th style="width:10%;">Order No.</th>
            <th style="width:15%;">Branch</th>
            <th style="width:35%;">Items</th>
            <th style="width:15%;">Status</th>
            <th style="width:25%;">Date</th>
        </tr>
    </thead>

    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->user->branch ?? 'N/A' }}</td>

            <td>
                @foreach($order->items as $item)
                    <div>{{ $item->item_name }} (x{{ $item->pivot->quantity }})</div>
                @endforeach
            </td>

            <td>
                @if($order->status == 'approved')
                    <span style="color:green;">Approved</span>
                @elseif($order->status == 'cancelled')
                    <span style="color:red;">Cancelled</span>
                @else
                    <span style="color:orange;">Pending</span>
                @endif
            </td>

            <td>{{ $order->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">No orders found</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection