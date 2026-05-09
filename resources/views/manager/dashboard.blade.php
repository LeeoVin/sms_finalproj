@extends('layouts.app')

@section('title', 'POS Dashboard')

@section('content')

<h2 style="margin-bottom:25px; color:#322922;">
    Menu
</h2>
@if(session('success'))
    <div style="
        background:#d4edda;
        color:#155724;
        padding:14px 18px;
        border-radius:12px;
        margin-bottom:20px;
        border:1px solid #c3e6cb;
        font-weight:bold;
    ">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('manager.pos.store') }}" method="POST">
@csrf

<div style="display:grid; grid-template-columns: 1.3fr 1fr; gap:25px; align-items:start;">

{{-- LEFT SIDE --}}
<div style="background:white; border-radius:18px; padding:25px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">

    <h3 style="margin-bottom:25px; color:#322922;">Menu</h3>

    @php
        $groupedMenus = $menus->groupBy('category');
    @endphp

    @foreach($groupedMenus as $category => $items)

        <h4 style="color:#E93F0C;">{{ $category }}</h4>

        @foreach($items as $menu)

        <div style="display:flex; justify-content:space-between; padding:12px; background:#fafafa; margin-bottom:10px; border-radius:10px;">
            <div>
                <strong>{{ $menu->menu_name }}</strong><br>
                ₱{{ number_format($menu->price, 2) }}
            </div>
        </div>

        @endforeach
    @endforeach

</div>

{{-- RIGHT SIDE --}}
<div style="
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    position:sticky;
    top:20px;
">

    <h3 style="
        margin-bottom:20px;
        color:#322922;
        border-bottom:2px solid #f1f1f1;
        padding-bottom:10px;
    ">
        Customer Order
    </h3>

    {{-- ADD ITEM --}}
    <div style="
        display:flex;
        flex-direction:column;
        gap:12px;
        margin-bottom:25px;
    ">

        <label style="font-size:14px; color:#666;">
            Select Menu Item
        </label>

        <select id="menuSelect" style="
            padding:12px;
            border-radius:10px;
            border:1px solid #ddd;
            font-size:15px;
        ">
            @foreach($menus as $menu)
                <option value="{{ $menu->menu_id }}"
                        data-name="{{ $menu->menu_name }}"
                        data-price="{{ $menu->price }}">
                    {{ $menu->menu_name }} - ₱{{ number_format($menu->price, 2) }}
                </option>
            @endforeach
        </select>

        <label style="font-size:14px; color:#666;">
            Quantity
        </label>

        <div style="display:flex; gap:10px;">

            <input
                type="number"
                id="menuQty"
                value="1"
                min="1"
                style="
                    flex:1;
                    padding:12px;
                    border-radius:10px;
                    border:1px solid #ddd;
                    font-size:15px;
                "
            >

            <button
                type="button"
                onclick="addMenuItem()"
                style="
                    background:#69BAB7;
                    color:white;
                    border:none;
                    border-radius:10px;
                    padding:0 20px;
                    cursor:pointer;
                    font-weight:bold;
                    font-size:18px;
                "
            >
                +
            </button>

        </div>

    </div>

    {{-- ORDER SUMMARY --}}
    <div style="
        background:#fafafa;
        border-radius:14px;
        padding:18px;
        margin-bottom:20px;
        border:1px solid #eee;
    ">

        <h4 style="
            margin-bottom:15px;
            color:#322922;
        ">
            Order Summary
        </h4>

        <div id="orderSummary" style="
            min-height:120px;
        ">
            <p style="color:#999;">
                No items added.
            </p>
        </div>

    </div>

    {{-- TOTAL --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        padding:15px;
        background:#FFF7F3;
        border-radius:12px;
    ">

        <span style="
            font-size:18px;
            font-weight:bold;
            color:#322922;
        ">
            Total
        </span>

        <span style="
            font-size:24px;
            font-weight:bold;
            color:#E93F0C;
        ">
            ₱<span id="totalPrice">0.00</span>
        </span>

    </div>

    {{-- SUBMIT --}}
    <button
        class="btn-submit"
        style="
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:#69BAB7;
            color:white;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
        "
    >
        Place Order
    </button>

</div>

{{-- HIDDEN INPUTS --}}
<div id="hiddenInputs"></div>

</form>

<script>

let total = 0;
let itemIndex = 0;

function addMenuItem() {

    const select = document.getElementById('menuSelect');
    const selected = select.options[select.selectedIndex];

    const id = selected.value;
    const name = selected.dataset.name;
    const price = parseFloat(selected.dataset.price);
    const qty = parseInt(document.getElementById('menuQty').value);

    if (qty <= 0 || isNaN(qty)) {
        alert('Invalid quantity');
        return;
    }

    const subtotal = price * qty;
    total += subtotal;

    document.getElementById('totalPrice').innerText = total.toFixed(2);

    const summary = document.getElementById('orderSummary');

    if (summary.innerText.includes('No items')) {
        summary.innerHTML = '';
    }

    summary.innerHTML += `
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:12px;
        background:white;
        border-radius:10px;
        margin-bottom:10px;
        border:1px solid #eee;
    ">

        <div>
            <div style="
                font-weight:bold;
                color:#322922;
                margin-bottom:4px;
            ">
                ${name}
            </div>

            <div style="
                font-size:14px;
                color:#777;
            ">
                Qty: ${qty}
            </div>
        </div>

        <div style="
            font-weight:bold;
            color:#E93F0C;
        ">
            ₱${subtotal.toFixed(2)}
        </div>

    </div>
    `;

    // ✅ IMPORTANT: ADD HIDDEN INPUTS
    const container = document.getElementById('hiddenInputs');

    const wrapper = document.createElement('div');

    wrapper.innerHTML = `
        <input type="hidden" name="items[${itemIndex}][menu_id]" value="${id}">
        <input type="hidden" name="items[${itemIndex}][quantity]" value="${qty}">
    `;

    container.appendChild(wrapper);

    itemIndex++;
}

</script>

@endsection