<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;
use App\Services\InventoryService;
use App\Models\BranchStock;

class OrderController extends Controller
{
    /* ================= ADMIN ================= */

    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    /* ================= CREATE ================= */

    public function create()
    {
        $items = Item::all();

        return view('manager.create_order', compact('items'));
    }

    /* ================= STORE PURCHASE ORDER ================= */

    public function store(Request $request)
{
    // 🔥 DEBUG: see EXACT request payload
    \Log::info('ORDER REQUEST:', $request->all());

    $request->validate([
        'items' => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:items,item_id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    $user = User::find(session('user_id'));

    if (!$user) {
        return back()->with('error', 'User session missing');
    }

    DB::beginTransaction();

    try {

        $order = DB::table('sales_receipts')->insertGetId([
            'branch' => $user->branch,
            'total' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $total = 0;

        foreach ($request->items as $index => $item) {

            // 🔥 DEBUG EACH ITEM
            \Log::info("ITEM LOOP [$index]:", $item);

            if (!isset($item['item_id']) || !isset($item['quantity'])) {
                throw new \Exception("Invalid item structure at index $index");
            }

            $supply = Item::find($item['item_id']);

            if (!$supply) {
                throw new \Exception("Item not found: " . $item['item_id']);
            }

            $qty = (int) $item['quantity'];
            $price = (float) $supply->price;

            // 🔥 INSERT CHECKPOINT
            DB::table('order_items')->insert([
                'order_id' => $order->order_id,
                'item_id' => $supply->item_id,
                'quantity' => $qty,
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $total += $qty * $price;
        }

        $order->update([
            'total_price' => $total
        ]);

        DB::commit();

        return redirect()
            ->route('manager.orders.index')
            ->with('success', 'Order placed successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}
public function storePOS(Request $request)
{
    $request->validate([
        'items' => 'required|array|min:1',
        'items.*.menu_id' => 'required|exists:menu_items,menu_id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    $user = User::find(session('user_id'));

    if (!$user) {
        return back()->with('error', 'User session missing');
    }

    DB::beginTransaction();

    try {

        foreach ($request->items as $item) {

            $menu = \App\Models\MenuItem::findOrFail($item['menu_id']);

            $qty = (int) $item['quantity'];
            $price = (float) $menu->price;

            \App\Models\Sale::create([
                'menu_id' => $menu->menu_id,
                'quantity' => $qty,
                'price' => $price,
                'total' => $qty * $price,
                'branch' => $user->branch,
            ]);
        }

        DB::commit();

        return back()->with('success', 'POS recorded to SALES only.');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}
    /* ================= MANAGER ORDERS ================= */

    public function managerOrders()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect('/login');
        }

        $orders = Order::with(['user', 'items'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('manager.orders', compact('orders'));
    }
    public function confirmDelivery(Order $order)
{
    if ($order->status !== 'approved') {
        return back()->with('error', 'Order is not ready for delivery confirmation.');
    }

    DB::transaction(function () use ($order) {

        // 1. Update order status
        $order->update([
            'status' => 'delivered'
        ]);

        // 2. ADD ITEMS TO INVENTORY
        foreach ($order->items as $item) {

            $stock = BranchStock::where('item_id', $item->item_id)
                ->where('branch', $order->branch)
                ->first();

            if ($stock) {
                // increase existing stock
                $stock->increment('stock', $item->pivot->quantity);
            } else {
                // create stock record if missing
                BranchStock::create([
                    'item_id' => $item->item_id,
                    'branch' => $order->branch,
                    'stock' => $item->pivot->quantity
                ]);
            }
        }
    });

    return back()->with('success', 'Delivery confirmed and inventory updated.');
}
}