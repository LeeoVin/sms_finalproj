<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\BranchStock;
use App\Models\ItemAdjustment;

class ItemController extends Controller
{
    public function storeAdjustment(Request $request)
{
    $request->validate([
        'item_id' => 'required',
        'quantity' => 'required|integer|min:1',
        'reason' => 'required'
    ]);

    $user = User::find(session('user_id'));

    if (!$user) {
        return redirect('/login');
    }

    ItemAdjustment::create([
        'item_id' => $request->item_id,
        'user_id' => $user->id,
        'branch' => $user->branch,
        'quantity' => $request->quantity,
        'reason' => $request->reason,
        'status' => 'pending'
    ]);

    return back()->with(
        'success',
        'Adjustment request submitted.'
    );
}
    /* ================= ADMIN ================= */

    public function index()
    {
        $items = Item::with('supplier')->oldest()->get();

        return view('admin.items', compact('items'));
    }

    public function create()
    {
        return view('admin.create_item');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'price' => 'nullable|numeric|min:0',
            'count' => 'nullable|integer|min:0',
            'category' => 'required|string',
        ]);

        Item::create([
            'item_name' => $request->item_name,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price ?? 0,
            'count' => $request->count ?? 0,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item created successfully.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('admin.edit_item', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'price' => 'nullable|numeric|min:0',
            'count' => 'nullable|integer|min:0',
            'category' => 'required|string',
            
        ]);

        $item = Item::findOrFail($id);

        $item->update([
            'item_name' => $request->item_name,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price ?? 0,
            'count' => $request->count ?? 0,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();

        return back()->with('success', 'Item deleted.');
    }

    /* ================= MANAGER ================= */

    public function managerIndex()
    {
        $user = User::find(session('user_id'));

        if (!$user) return redirect('/login');

        $items = Item::with(['branchStocks' => function ($q) use ($user) {
            $q->where('branch', $user->branch);
        }])->get();

        return view('manager.items', compact('items'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $user = User::find(session('user_id'));
        if (!$user) return redirect('/login');

        $branch = $user->branch ?? 'default';

        $stock = BranchStock::firstOrCreate(
            [
                'item_id' => $id,
                'branch' => $branch
            ],
            [
                'stock' => 0
            ]
        );

        $stock->stock = $request->stock;
        $stock->save();

        return back()->with('success', 'Stock updated.');
    }
}
