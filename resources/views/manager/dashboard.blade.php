@extends('layouts.app')

@section('title', 'POS Dashboard')

@section('content')

<h2 style="margin-bottom:25px; color:#322922;">
    Point of Sale
</h2>
@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('manager.orders.store') }}" method="POST">
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
<div style="background:white; border-radius:18px; padding:25px;">

    <h3>Customer Order</h3>

    <div style="display:flex; gap:10px; margin-bottom:15px;">

        <select id="menuSelect">
            @foreach($menus as $menu)
                <option value="{{ $menu->menu_id }}"
                        data-name="{{ $menu->menu_name }}"
                        data-price="{{ $menu->price }}">
                    {{ $menu->menu_name }} - ₱{{ $menu->price }}
                </option>
            @endforeach
        </select>

        <input type="number" id="menuQty" value="1" min="1">

        <button type="button" onclick="addMenuItem()">+</button>
    </div>

    <h4>Order Summary</h4>
    <div id="orderSummary">No items added.</div>

    <h3>Total: ₱<span id="totalPrice">0.00</span></h3>

    <button class="btn-submit" style="width:100%;">Place Order</button>
</div>

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

    const subtotal = price * qty;
    total += subtotal;

    document.getElementById('totalPrice').innerText = total.toFixed(2);

    const summary = document.getElementById('orderSummary');

    if (summary.innerText.includes('No items')) {
        summary.innerHTML = '';
    }

    summary.innerHTML += `
        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
            <div>
                <strong>${name}</strong><br>
                Qty: ${qty}
            </div>
            <div>₱${subtotal.toFixed(2)}</div>
        </div>
    `;

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