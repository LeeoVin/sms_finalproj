@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Branch Inventory</h2>

{{-- ================= INVENTORY TABLE ================= --}}
<div style="
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
    overflow-x:auto;
">

<table style="width:100%; border-collapse:collapse;">

    <thead>
        <tr style="text-align:left; border-bottom:2px solid #eee;">
            <th style="padding:10px;">Item</th>
            <th style="padding:10px;">Quantity</th>
            <th style="padding:10px;">Status</th>
        </tr>
    </thead>

    <tbody>

    @foreach($items as $item)

        @php
            $stock = $item->branchStocks->first()->stock ?? 0;

            $status =
                $stock <= 0 ? 'Out of Stock' :
                ($stock <= 10 ? 'Low' : 'Available');
        @endphp

        <tr style="border-bottom:1px solid #f1f1f1;">
            <td style="padding:12px;">{{ $item->item_name }}</td>
            <td style="padding:12px;">{{ $stock }}</td>

            <td style="padding:12px;">
                <span style="
                    padding:5px 10px;
                    border-radius:20px;
                    font-size:12px;
                    font-weight:bold;
                    color:white;
                    background:
                        {{ $status == 'Available' ? '#2ecc71' :
                           ($status == 'Low' ? '#f39c12' : '#e74c3c') }};
                ">
                    {{ $status }}
                </span>
            </td>
        </tr>

    @endforeach

    </tbody>

</table>

</div>

<br>

{{-- ================= BUTTON ================= --}}
<button class="btn-delete"
        onclick="openDisposeModal()"
        style="
            cursor:pointer;
            padding:10px 15px;
            border-radius:8px;
        ">
    Request Rid of Stocks
</button>

{{-- ================= MODAL ================= --}}
<div id="disposeModal" class="modal">

    <div class="modal-content">

        <h3 style="margin-bottom:15px;">Request Disposal of Stocks</h3>

        <form method="POST" action="{{ route('manager.adjustment.store') }}">
            @csrf

            {{-- ITEM SELECT --}}
            <label style="font-weight:bold;">Items</label>

            <select name="item_id"
                    style="
                        width:100%;
                        padding:10px;
                        margin-top:6px;
                        border-radius:8px;
                        border:1px solid #ddd;
                    ">
                @foreach($items as $item)
                    <option value="{{ $item->item_id }}">
                        {{ $item->item_name }}
                    </option>
                @endforeach
            </select>

            <br><br>

            {{-- QUANTITY --}}
            <label style="font-weight:bold;">Quantity to Dispose</label>

            <input type="number"
                   name="quantity"
                   min="1"
                   required
                   style="
                        width:100%;
                        padding:10px;
                        margin-top:6px;
                        border-radius:8px;
                        border:1px solid #ddd;
                   ">

            <br><br>

            {{-- REASON --}}
            <label style="font-weight:bold;">Reason</label>

            <textarea name="reason"
                      required
                      placeholder="e.g. spoiled, expired, damaged"
                      style="
                          width:100%;
                          height:90px;
                          padding:10px;
                          margin-top:6px;
                          border-radius:8px;
                          border:1px solid #ddd;
                          resize:none;
                      ">
            </textarea>

            <br><br>

            {{-- SUBMIT --}}
            <button class="btn-submit"
                    style="
                        width:100%;
                        padding:10px;
                        border-radius:8px;
                        cursor:pointer;
                    ">
                Send Request
            </button>

        </form>

        <br>

        <button onclick="closeDisposeModal()"
                class="btn-delete"
                style="
                    width:100%;
                    padding:10px;
                    border-radius:8px;
                    cursor:pointer;
                ">
            Close
        </button>

    </div>

</div>

{{-- ================= MODAL STYLE ================= --}}
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

    /* center fix */
    justify-content:center;
    align-items:center;
}

.modal-content {
    background:white;
    width:90%;
    max-width:420px;
    margin:auto;
    padding:20px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}
</style>

{{-- ================= SCRIPT ================= --}}
<script>

function openDisposeModal() {
    document.getElementById('disposeModal').style.display = 'flex';
}

function closeDisposeModal() {
    document.getElementById('disposeModal').style.display = 'none';
}

// click outside modal to close
window.onclick = function(event) {
    let modal = document.getElementById('disposeModal');

    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>

@endsection