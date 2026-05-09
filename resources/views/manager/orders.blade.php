@extends('layouts.app')

@section('title', 'Orders')

@section('content')

<h2>Orders</h2>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Branch</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)
        <tr onclick="openModal({{ $order->order_id }})" style="cursor:pointer;">
            <td>{{ $order->order_id }}</td>

            <td>{{ $order->user->branch }}</td>

            <td>{{ $order->created_at->format('Y-m-d') }}</td>

            <td>
                ₱{{ number_format(
                    $order->menuItems->sum(function ($i) {
                        return $i->pivot->price * $i->pivot->quantity;
                    }),
                    2
                ) }}
            </td>

            <td>
                @if($order->status == 'approved')
                    <span style="color:#3498db;">Approved</span>
                @elseif($order->status == 'delivered')
                    <span style="color:green;">Delivered</span>
                @elseif($order->status == 'cancelled')
                    <span style="color:red;">Cancelled</span>
                @else
                    <span style="color:orange;">Pending</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align:center;">No orders</td>
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

        <hr>

        <h4>Items:</h4>

        @foreach($order->menuItems as $item)
            <p>
                {{ $item->menu_name }}
                (x{{ $item->pivot->quantity }})
                - ₱{{ number_format($item->pivot->price, 2) }}
            </p>
        @endforeach

        <hr>

        <h4>
            Total:
            ₱{{ number_format(
                $order->menuItems->sum(function ($i) {
                    return $i->pivot->price * $i->pivot->quantity;
                }),
                2
            ) }}
        </h4>

        <br>

        @if($order->status == 'pending')
            <form action="{{ route('manager.orders.cancel', $order->order_id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to cancel this order?')">
                @csrf
                <button class="btn-delete" style="width:100%;">
                    Cancel Order
                </button>
            </form>

        @elseif($order->status == 'approved')

            <form action="{{ route('manager.orders.confirmDelivery', $order->order_id) }}"
                  method="POST"
                  onsubmit="return confirm('Confirm delivery received?')">

                @csrf

                <button class="btn-submit" style="width:100%;">
                    Confirm Delivery
                </button>

            </form>

        @elseif($order->status == 'delivered')

            <p style="color:green;">Delivery Received</p>

        @else

            <p style="color:gray;">
                Order already {{ $order->status }}
            </p>

        @endif

        <br>

        <button onclick="closeModal({{ $order->order_id }})"
                class="btn-submit" style="width:100%;">
            Close
        </button>

    </div>
</div>

@endforeach


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
    width:400px;
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