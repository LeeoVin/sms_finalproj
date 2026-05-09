@extends('layouts.app')

@section('title', 'Supervisor Orders')

@section('content')

<h2>Pending Orders</h2>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Branch</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)

        <tr style="cursor:pointer;"
            onclick="openOrderModal(
                {{ $order->order_id }},
                '{{ $order->user->branch }}',
                @js($order->items),
                '{{ $order->status }}'
            )">

            <td>{{ $order->order_id }}</td>
            <td>{{ $order->user->branch }}</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>
            <td>{{ ucfirst($order->status) }}</td>

        </tr>

    @empty

        <tr>
            <td colspan="4" style="text-align:center;">
                No orders found
            </td>
        </tr>

    @endforelse
    </tbody>
</table>

{{-- ================= SINGLE MODAL ================= --}}
<div id="orderModal" class="modal">
    <div class="modal-content">

        <h3>Order #<span id="modalOrderId"></span></h3>

        <p>
            <strong>Branch:</strong>
            <span id="modalBranch"></span>
        </p>

        <hr>

        <div id="modalItems"></div>

        <hr>

        <div id="modalActions"></div>

        <br>

        <button onclick="closeOrderModal()"
                class="btn-submit btn-small"
                style="width:100%;">
            Close
        </button>

    </div>
</div>

{{-- ================= MODAL STYLE ================= --}}
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: #fff;
    margin: 6% auto;
    padding: 25px;
    width: 400px;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
}
</style>

{{-- ================= SCRIPT ================= --}}
<script>

function openOrderModal(id, branch, items, status) {

    document.getElementById('orderModal').style.display = 'block';

    document.getElementById('modalOrderId').innerText = id;
    document.getElementById('modalBranch').innerText = branch;

    // ITEMS
    let itemsHtml = '';

    items.forEach(item => {
        itemsHtml += `
            <p>
                ${item.item_name}
                (x${item.pivot.quantity})
            </p>
        `;
    });

    document.getElementById('modalItems').innerHTML = itemsHtml;

    // ACTIONS (FIXED)
    let actionsHtml = '';

    if (status === 'pending') {

        actionsHtml = `
            <form method="POST" action="{{ url('/supervisor/orders') }}/${id}/approve" style="margin-bottom:10px;">
                @csrf
                <button class="btn-add btn-small" style="width:100%;">
                    Approve
                </button>
            </form>

            <form method="POST" action="{{ url('/supervisor/orders') }}/${id}/cancel">
                @csrf
                <button class="btn-delete btn-small" style="width:100%;">
                    Cancel
                </button>
            </form>
        `;

    } else {

        actionsHtml = `<p>Status: <strong>${status}</strong></p>`;
    }

    document.getElementById('modalActions').innerHTML = actionsHtml;
}

function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}

// click outside modal
window.onclick = function(event) {
    let modal = document.getElementById('orderModal');

    if (event.target === modal) {
        modal.style.display = "none";
    }
}

</script>

@endsection