@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Menu Management</h2>

<button class="btn-add" onclick="openModal()">
    + Add Product
</button>

<br><br>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            
            <th width="180">Action</th>
        </tr>
    </thead>

    <tbody>

@forelse($menus as $menu)

    {{-- MAIN ROW --}}
    <tr
        onclick="toggleSupplies({{ $menu->menu_id }})"
        style="cursor:pointer;">

        <td>
            <strong>{{ $menu->menu_name }}</strong>
        </td>

        <td>{{ $menu->category }}</td>

        <td>₱{{ number_format($menu->price, 2) }}</td>

        <td>

            <div class="action-buttons">

                <button
                    type="button"
                    class="btn-edit"
                    onclick='event.stopPropagation(); editMenu(@json($menu))'>
                    Edit
                </button>

                <form method="POST"
                      action="{{ route('admin.menu.delete', $menu->menu_id) }}"
                      onclick="event.stopPropagation();">

                    @csrf
                    @method('DELETE')

                    <button class="btn-delete"
                            onclick="return confirm('Delete this product?')">
                        Delete
                    </button>

                </form>

            </div>

        </td>

    </tr>

    {{-- SUPPLIES ROW --}}
    <tr
        id="supplies-{{ $menu->menu_id }}"
        style="display:none; background:#fff8f5;">

        <td colspan="4">

            <div style="padding:10px 20px;">

                <strong>Supplies Used:</strong>

                <div style="margin-top:10px;">

                    @forelse($menu->supplies as $supply)

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            padding:8px 12px;
                            background:white;
                            border-radius:8px;
                            margin-bottom:8px;
                            border:1px solid #eee;
                        ">

                            <span>
                                {{ $supply->item_name }}
                            </span>

                            <span>
                                Qty:
                                {{ $supply->pivot->quantity_needed }}
                            </span>

                        </div>

                    @empty

                        <p>No supplies assigned.</p>

                    @endforelse

                </div>

            </div>

        </td>

    </tr>

@empty

<tr>
    <td colspan="4" style="text-align:center;">
        No menu items found
    </td>
</tr>

@endforelse

</tbody>
</table>

{{-- ================= MODAL ================= --}}
<div class="modal" id="menuModal">

    <div class="modal-content">

        <h3 id="modalTitle">Add Product</h3>

        <form method="POST" action="{{ route('admin.menu.store') }}">

            @csrf

            <input type="hidden" name="menu_id" id="menu_id">

            {{-- PRODUCT NAME --}}
            <div class="form-group">

                <label>Product Name</label>

                <input type="text"
                       name="menu_name"
                       id="menu_name"
                       required>

            </div>

            {{-- CATEGORY --}}
            <div class="form-group">

                <label>Category</label>

                <select name="category" id="category" required>

                    <option value="">Select Category</option>

                    <option value="Burger">Burger</option>
                    <option value="Drinks">Drinks</option>
                    <option value="Fries">Fries</option>
                    <option value="Meal">Meal</option>

                </select>

            </div>

            {{-- PRICE --}}
            <div class="form-group">

                <label>Price</label>

                <input type="number"
                       step="0.01"
                       name="price"
                       id="price"
                       required>

            </div>

            <hr>
            <h4>Items</h4>

                <div id="suppliesContainer"></div>

                <div style="display:flex; align-items:center; gap:8px;">

                    <button type="button"
                            class="btn-add"
                            style="
                                width:40px;
                                height:40px;
                                padding:0;
                                border-radius:8px;
                                font-size:20px;
                            "
                            onclick="addSupplyRow()">

                        +

                    </button>

                </div>

            <br><br>

            <button class="btn-submit full-width">
                Save Product
            </button>

        </form>

        <br>

        <button class="btn-delete full-width"
                onclick="closeModal()">

            Cancel

        </button>

    </div>

</div>

{{-- ================= SCRIPT ================= --}}
<script>

const items = @json($items);

function openModal() {

    document.getElementById('menuModal').style.display = 'block';

    document.getElementById('modalTitle').innerText = 'Add Product';

    document.getElementById('menu_id').value = '';
    document.getElementById('menu_name').value = '';
    document.getElementById('category').value = '';
    document.getElementById('price').value = '';

    document.getElementById('suppliesContainer').innerHTML = '';

    addSupplyRow();
}

function closeModal() {

    document.getElementById('menuModal').style.display = 'none';
}

function addSupplyRow(selectedId = '', qty = '') {

    let html = `
    <div class="supply-row"
         style="
            display:flex;
            gap:10px;
            margin-bottom:12px;
            align-items:center;
            background:#f9f9f9;
            padding:10px;
            border-radius:10px;
            border:1px solid #eee;
         ">

        <select
            name="supply_item_id[]"
            required
            style="
                flex:1;
                padding:10px;
                border-radius:8px;
                border:1px solid #ddd;
            ">

            <option value="">
                Select Supply Item
            </option>

            ${items.map(item => `
                <option
                    value="${item.item_id}"
                    ${selectedId == item.item_id ? 'selected' : ''}>
                    ${item.item_name}
                </option>
            `).join('')}

        </select>

        <input type="number"
               name="supply_quantity[]"
               placeholder="Qty"
               value="${qty}"
               min="1"
               required
               style="
                    width:90px;
                    padding:10px;
                    border-radius:8px;
                    border:1px solid #ddd;
               ">

        <button type="button"
                onclick="removeSupplyRow(this)"
                class="btn-delete"
                style="
                    width:40px;
                    height:40px;
                    border-radius:8px;
                    cursor:pointer;
                ">
            ×
        </button>

    </div>
`;

    document.getElementById('suppliesContainer')
        .insertAdjacentHTML('beforeend', html);
}
function removeSupplyRow(button) {

    button.parentElement.remove();
}

function editMenu(menu) {

    openModal();

    document.getElementById('modalTitle').innerText = 'Edit Product';
    document.getElementById('menu_id').value = menu.menu_id;
    document.getElementById('menu_name').value = menu.menu_name;
    document.getElementById('category').value = menu.category;
    document.getElementById('price').value = menu.price;
    document.getElementById('suppliesContainer').innerHTML = '';

    if (menu.supplies.length > 0) {

        menu.supplies.forEach(supply => {
            addSupplyRow(
                supply.item_id,
                supply.pivot.quantity_needed
            );

        });

    } else {
        addSupplyRow();
    }
}

window.onclick = function(event) {

    const modal = document.getElementById('menuModal');

    if (event.target === modal) {
        closeModal();
    }
}
function toggleSupplies(id) {

    const row = document.getElementById('supplies-' + id);

    if (row.style.display === 'none') {

        row.style.display = 'table-row';

    } else {

        row.style.display = 'none';
    }
}

</script>

@endsection