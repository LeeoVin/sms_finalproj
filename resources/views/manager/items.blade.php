@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px; color:#322922;">
    Branch Inventory
</h2>

{{-- ✅ SUCCESS MESSAGE --}}
@if(session('success'))
    <div style="
        background:#d4edda;
        color:#155724;
        padding:12px 15px;
        border-radius:10px;
        margin-bottom:15px;
        font-weight:bold;
    ">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="
        background:#f8d7da;
        color:#721c24;
        padding:12px 15px;
        border-radius:10px;
        margin-bottom:15px;
        font-weight:bold;
    ">
        {{ session('error') }}
    </div>
@endif

{{-- ================= INVENTORY TABLE ================= --}}
<div style="
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
    overflow-x:auto;
">

<table style="width:100%; border-collapse:collapse;">

    {{-- HEADER (FIXED VISIBILITY) --}}
    <thead>
        <tr style="background:#f4f4f4; text-align:left;">
            <th style="padding:12px; border-bottom:1px solid #ddd;">Item</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Quantity</th>
            <th style="padding:12px; border-bottom:1px solid #ddd;">Status</th>
        </tr>
    </thead>

    <tbody>

    @foreach($items as $item)

        @php
            $stock = $item->branchStocks->first()->stock ?? 0;

            $status =
                $stock <= 0 ? 'Out of Stock' :
                ($stock <= 10 ? 'Low Stock' : 'Available');
        @endphp

        <tr style="border-bottom:1px solid #f1f1f1;">

            <td style="padding:12px;">
                {{ $item->item_name }}
            </td>

            <td style="padding:12px;">
                {{ $stock }}
            </td>

            <td style="padding:12px;">

                <span style="
                    padding:5px 10px;
                    border-radius:20px;
                    font-size:12px;
                    font-weight:bold;
                    color:white;
                    background:
                        {{ $status == 'Available' ? '#2ecc71' :
                           ($status == 'Low Stock' ? '#f39c12' : '#e74c3c') }};
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
<button onclick="openDisposeModal()"
        style="
            cursor:pointer;
            padding:10px 15px;
            border-radius:8px;
            background:#322922;
            color:white;
            border:none;
        ">
    Request Disposal of Stocks
</button>

{{-- ================= MODAL ================= --}}
<div id="disposeModal" class="modal">

    <div class="modal-content">

        <h3 style="margin-bottom:15px;">
            Request Disposal of Stocks
        </h3>

        <form method="POST" action="{{ route('manager.adjustment.store') }}">
    @csrf

    <div style="display:flex; flex-direction:column; gap:12px;">

        {{-- ITEM --}}
        <label style="font-weight:600; font-size:14px; color:#333;">
            Item
        </label>

        <select name="item_id" class="form-control">
            @foreach($items as $item)
                <option value="{{ $item->item_id }}">
                    {{ $item->item_name }}
                </option>
            @endforeach
        </select>

        {{-- QUANTITY --}}
        <label style="font-weight:600; font-size:14px; color:#333;">
            Quantity to Dispose
        </label>

        <input type="number"
               name="quantity"
               min="1"
               required
               class="form-control">

        {{-- REASON --}}
        <label style="font-weight:600; font-size:14px; color:#333;">
            Reason
        </label>

        <textarea name="reason"
                  required
                  placeholder="e.g. spoiled, expired, damaged"
                  class="form-control textarea">
        </textarea>

        {{-- SUBMIT --}}
        <button class="btn-submit"
                style="
                    margin-top:10px;
                    width:100%;
                    padding:12px;
                    border-radius:10px;
                    background:#69BAB7;
                    color:white;
                    border:none;
                    font-weight:bold;
                    cursor:pointer;
                ">
            Send Request
        </button>

    </div>
</form>

        <br>

        <button onclick="closeDisposeModal()"
                style="
                    width:100%;
                    padding:10px;
                    border:none;
                    border-radius:8px;
                    background:#322922;
                    color:white;
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
    justify-content:center;
    align-items:center;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 420px;
    margin: auto;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);

    /* ✅ IMPORTANT FIXES */
    box-sizing: border-box;
    overflow: hidden;
}
.form-control {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box; /* 🔥 this is the key fix */
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
    outline: none;
}

.form-control:focus {
    border-color: #69BAB7;
    box-shadow: 0 0 0 3px rgba(105,186,183,0.2);
}

.textarea {
    height: 90px;
    resize: none;
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

window.onclick = function(event) {
    let modal = document.getElementById('disposeModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>

@endsection