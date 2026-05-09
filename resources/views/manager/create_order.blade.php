@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Purchase Order (Supplies)</h2>

<form action="{{ route('manager.orders.store') }}" method="POST">
@csrf

<div id="items-container">

    <div class="item-row" style="display:flex; gap:10px; margin-bottom:15px;">

        <select name="items[0][item_id]" required style="flex:2;">
            <option value="">-- Select Supply Item --</option>
            @foreach($items as $item)
                <option value="{{ $item->item_id }}">
                    {{ $item->item_name }}
                </option>
            @endforeach
        </select>

        <input type="number"
               name="items[0][quantity]"
               min="1"
               required
               placeholder="Qty"
               style="flex:1;">

        <button type="button" onclick="removeRow(this)">✕</button>
    </div>

</div>

<button type="button" onclick="addItem()">+ Add Item</button>

<br><br>

<button type="submit">Place Order</button>

</form>

<script>
let index = 1;

function addItem() {
    let container = document.getElementById('items-container');

    container.insertAdjacentHTML('beforeend', `
        <div class="item-row" style="display:flex; gap:10px; margin-bottom:15px;">
            <select name="items[${index}][item_id]" required style="flex:2;">
                <option value="">-- Select Supply Item --</option>
                @foreach($items as $item)
                    <option value="{{ $item->item_id }}">
                        {{ $item->item_name }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="items[${index}][quantity]" min="1" required style="flex:1;">

            <button type="button" onclick="removeRow(this)">✕</button>
        </div>
    `);

    index++;
}

function removeRow(btn) {
    btn.parentElement.remove();
}
</script>

@endsection