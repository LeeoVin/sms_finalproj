@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Purchase Order (Supplies)</h2>

<form action="{{ route('manager.orders.store') }}" method="POST">
@csrf

<div style="max-width:700px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

    <div id="items-container">

        <div class="item-row" style="display:flex; gap:10px; margin-bottom:15px;">

            <select name="items[0][item_id]" required style="flex:2; padding:10px;">
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
                   style="flex:1; padding:10px;">

            <button type="button"
                    onclick="this.parentElement.remove()"
                    style="background:red; color:white; border:none; padding:10px; border-radius:6px;">
                ✕
            </button>

        </div>

    </div>

    <button type="button"
            onclick="addItem()"
            style="margin-top:10px; padding:10px 15px; background:#69BAB7; color:white; border:none; border-radius:8px;">
        + Add Item
    </button>

    <hr style="margin:20px 0;">

    <button type="submit"
            style="width:100%; padding:12px; background:#322922; color:white; border:none; border-radius:8px;">
        Place Purchase Order
    </button>

</div>

</form>

<script>
let index = 1;

function addItem() {
    const container = document.getElementById('items-container');

    const row = document.createElement('div');
    row.style.display = "flex";
    row.style.gap = "10px";
    row.style.marginBottom = "15px";

    row.innerHTML = `
        <select name="items[${index}][item_id]" required style="flex:2; padding:10px;">
            <option value="">-- Select Supply Item --</option>
            @foreach($items as $item)
                <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
            @endforeach
        </select>

        <input type="number"
               name="items[${index}][quantity]"
               min="1"
               required
               placeholder="Qty"
               style="flex:1; padding:10px;">

        <button type="button"
                onclick="this.parentElement.remove()"
                style="background:red; color:white; border:none; padding:10px; border-radius:6px;">
            ✕
        </button>
    `;

    container.appendChild(row);
    index++;
}
</script>

@endsection