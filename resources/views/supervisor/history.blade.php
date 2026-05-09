@extends('layouts.app')

@section('title', 'Order History')

@section('content')

<h2>Order History</h2>

{{-- FILTER --}}
<form method="GET" style="margin-bottom:20px; display:flex; gap:10px;">

    <select name="month">
        <option value="">All Months</option>
        @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ date('F', mktime(0,0,0,$m,1)) }}
            </option>
        @endfor
    </select>

    <select name="year">
        <option value="">All Years</option>
        @for($y = now()->year; $y >= 2020; $y--)
            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                {{ $y }}
            </option>
        @endfor
    </select>

    <button class="btn-submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Items</th>
            <th>Branch</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>

            <td>
                @foreach($order->items as $item)
                    {{ $item->item_name }} (x{{ $item->pivot->quantity }})<br>
                @endforeach
            </td>

            <td>{{ $order->user->branch }}</td>

            <td>{{ $order->created_at->format('Y-m-d') }}</td>

            <td>
                ₱{{ number_format(
                    $order->items->sum(fn($i) => $i->pivot->price * $i->pivot->quantity),
                    2
                ) }}
            </td>

            <td>
                @if($order->status == 'approved')
                    <span style="color:green;">Approved</span>
                @else
                    <span style="color:red;">Cancelled</span>
                @endif
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                No order history found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection