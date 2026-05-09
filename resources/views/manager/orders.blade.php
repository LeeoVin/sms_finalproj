@extends('layouts.app')

@section('title', 'Orders')

@section('content')

<h2 style="margin-bottom:20px; color:#322922;">
    Purchase Orders
</h2>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:12px; border-radius:10px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:10px; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse; background:white; border-radius:12px; overflow:hidden;">

    {{-- HEADER (FIXED VISIBILITY) --}}
    <thead>
        <tr style="background:#f4f4f4; color:#322922; text-align:left;">
            <th style="padding:12px; border-bottom:1px solid #ddd;">No.</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Branch</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Date</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Total Price</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Status</th>
        </tr>
    </thead>

    <tbody>

    @forelse($orders as $order)
        <tr onclick="openModal({{ $order->order_id }})"
            style="cursor:pointer; border-bottom:1px solid #eee;">

            <td style="padding:12px;">{{ $order->order_id }}</td>
            <td>{{ $order->user->branch }}</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>

            <td>
                ₱{{ number_format(
                    $order->items->sum(function ($i) {
                        return $i->pivot->price * $i->pivot->quantity;
                    }),
                    2
                ) }}
            </td>

            <td>
                <span style="
                    padding:5px 10px;
                    border-radius:6px;
                    font-size:12px;
                    background:
                        {{ $order->status === 'approved' ? '#d4edda' :
                           ($order->status === 'delivered' ? '#cce5ff' :
                           '#fff3cd') }};
                    color:#333;
                    font-weight:bold;
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </td>

        </tr>

    @empty
        <tr>
            <td colspan="5" style="text-align:center; padding:20px;">
                No orders found
            </td>
        </tr>
    @endforelse

    </tbody>
</table>

{{-- ================= MODALS ================= --}}
@foreach($orders as $order)

<div id="modal-{{ $order->order_id }}" class="modal">

    <div class="modal-content">

        <h3>Order #{{ $order->order_id }}</h3>

        <p><strong>Branch:</strong> {{ $order->user->branch }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>

        <hr>

        <h4>Items</h4>

        @foreach($order->items as $item)
            <p>
                {{ $item->item_name }}
                (x{{ $item->pivot->quantity }})
                — ₱{{ number_format($item->pivot->price, 2) }}
            </p>
        @endforeach

        <hr>

        <h3>
            Total:
            ₱{{ number_format(
                $order->items->sum(function ($i) {
                    return $i->pivot->price * $i->pivot->quantity;
                }),
                2
            ) }}
        </h3>

        {{-- CONFIRM DELIVERY --}}
        @if($order->status === 'approved')

            <form method="POST"
                  action="{{ route('manager.orders.confirmDelivery', $order->order_id) }}"
                  onsubmit="return confirm('Confirm delivery? This will update inventory.')">

                @csrf

                <button type="submit" style="
                    width:100%;
                    margin-top:15px;
                    background:#28a745;
                    color:white;
                    border:none;
                    padding:12px;
                    border-radius:8px;
                    cursor:pointer;
                ">
                    Confirm Delivery
                </button>

            </form>

        @elseif($order->status === 'delivered')

            <div style="
                margin-top:15px;
                padding:10px;
                background:#e6f7e6;
                color:#2e7d32;
                border-radius:8px;
                text-align:center;
                font-weight:bold;
            ">
                ✔ Delivered
            </div>

        @endif

        <button onclick="closeModal({{ $order->order_id }})"
                style="
                    margin-top:15px;
                    width:100%;
                    padding:10px;
                    border:none;
                    background:#322922;
                    color:white;
                    border-radius:8px;
                    cursor:pointer;
                ">
            Close
        </button>

    </div>
</div>

@endforeach

{{-- MODAL STYLE --}}
<style>
.modal {
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    z-index:999;
}

.modal-content {
    background:white;
    width:420px;
    margin:8% auto;
    padding:20px;
    border-radius:12px;
}
</style>

<script>
function openModal(id){
    document.getElementById('modal-'+id).style.display = 'block';
}

function closeModal(id){
    document.getElementById('modal-'+id).style.display = 'none';
}
</script>

@endsection