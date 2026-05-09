<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Item; // ✅ SUPPLIES ONLY
use App\Services\InventoryService;

class OrderController extends Controller
{
    /* ================= ADMIN ================= */

    public function index()
    {
        $orders = Order::with(['user'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    /* ================= CREATE PURCHASE ORDER (SUPPLIES) ================= */

    public function create()
    {
        $items = Item::all(); // ✅ ONLY SUPPLIES

        return view('manager.create_order', compact('items'));
    }

    /* ================= STORE PURCHASE ORDER ================= */

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,item_id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = User::find(session('user_id'));

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id' => $user->id,
                'branch' => $user->branch,
                'status' => 'pending',
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {

                $supply = Item::find($item['item_id']); // ✅ FIXED (was MenuItem)

                if (!$supply) {
                    throw new \Exception("Supply item not found");
                }

                $qty = (int) $item['quantity'];

                // optional price (if you want later)
                $price = $supply->price ?? 0;

                DB::table('order_supply_usage')->insert([
                    'order_id' => $order->order_id,
                    'item_id' => $supply->item_id,
                    'quantity' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ✅ THIS IS YOUR INVENTORY UPDATE (SUPPLIES ONLY)
                InventoryService::deductSupply(
                    $supply->item_id,
                    $qty,
                    $user->branch
                );

                $total += $qty * $price;
            }

            $order->update([
                'total_price' => $total
            ]);

            DB::commit();

            return redirect()
                ->route('manager.orders.index')
                ->with('success', 'Purchase order placed successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }

    /* ================= MANAGER VIEW ================= */

    public function managerOrders()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect('/login');
        }

        $orders = Order::with(['user'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('manager.orders', compact('orders'));
    }

    public function managerCancel($id)
    {
        $user = User::find(session('user_id'));

        if (!$user) return redirect('/login');

        $order = Order::where('order_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) return back()->with('error', 'Order not found.');

        if ($order->status !== 'pending') {
            return back()->with('error', 'Cannot cancel.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled.');
    }

    /* ================= SUPERVISOR ================= */

    public function supervisorOrders()
    {
        $orders = Order::with(['user'])
            ->latest()
            ->get();

        return view('supervisor.orders', compact('orders'));
    }

    public function approve(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $order->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Order approved.');
    }
}