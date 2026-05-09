<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\ItemAdjustment;
use App\Models\Item;
use App\Models\BranchStock;
use App\Models\User;

class SupervisorController extends Controller
{
    
public function dashboard()
{
    $pendingOrders = Order::where('type', 'purchase')
    ->where('status', 'pending')
    ->count();

$approvedOrders = Order::where('type', 'purchase')
    ->where('status', 'approved')
    ->count();

    $adjustments = ItemAdjustment::with(['item', 'user'])
        ->where('status', 'pending')
        ->latest()
        ->get();

    $pendingAdjustments = $adjustments->count();

    // ✅ FIXED: USE order_items + items (NOT menu_items)
    $sales = DB::table('sales')
        ->join('menu_items', 'menu_items.menu_id', '=', 'sales.menu_id')
        ->selectRaw('
            MONTH(sales.created_at) as month,
            menu_items.menu_name as item_name,
            SUM(sales.quantity) as total_sold
        ')
        ->groupBy('month', 'menu_items.menu_id', 'menu_items.menu_name')
        ->get();

    $itemNames = $sales->pluck('item_name')->unique();

    $chartData = [];

    foreach ($itemNames as $name) {

        $data = array_fill(1, 12, 0);

        foreach ($sales->where('item_name', $name) as $row) {
            $data[$row->month] = $row->total_sold;
        }

        $chartData[] = [
            'label' => $name,
            'data' => array_values($data),
        ];
    }

    return view('supervisor.dashboard', compact(
        'pendingOrders',
        'approvedOrders',
        'adjustments',
        'pendingAdjustments',
        'chartData'
    ));
}
    // =========================
    // APPROVE ADJUSTMENT
    // =========================
   public function approveAdjustment($id)
{
    $adjustment = ItemAdjustment::with('item')->findOrFail($id);

    $stock = BranchStock::where('item_id', $adjustment->item_id)
        ->where('branch', $adjustment->branch)
        ->first();

    if (!$stock) {
        return back()->with('error', 'Stock record not found.');
    }

    if ($stock->stock < $adjustment->quantity) {
        return back()->with('error', 'Insufficient stock.');
    }

    DB::transaction(function () use ($adjustment, $stock) {

        $stock->decrement('stock', $adjustment->quantity);

        $adjustment->update([
            'status' => 'approved'
        ]);
    });

    return back()->with('success', 'Adjustment approved and stock updated.');
}
    // =========================
    // REJECT ADJUSTMENT
    // =========================
    public function rejectAdjustment($id)
{
    $adjustment = ItemAdjustment::findOrFail($id);

    if ($adjustment->status !== 'pending') {
        return back()->with('error', 'Already processed.');
    }

    $adjustment->update([
        'status' => 'rejected'
    ]);

    return back()->with('success', 'Request rejected.');
}

    // =========================
    // SUPPLIES VIEW (FILTER BY BRANCH)
    // =========================
    public function supplies(Request $request)
{
    $branch = $request->branch;

    $query = BranchStock::with('item');

    if ($branch) {
        $query->where('branch', $branch);
    }

    $stocks = $query->get();

    $branches = User::whereNotNull('branch')
    ->where('branch', '!=', 'Headquarters')
    ->distinct()
    ->pluck('branch');

    $adjustments = ItemAdjustment::with(['item', 'user'])
        ->where('status', 'pending')
        ->latest()
        ->get();

    return view('supervisor.supplies', compact(
        'stocks',
        'branches',
        'branch',
        'adjustments'
    ));
}
public function orders()
{
    $orders = Order::with(['user', 'items'])
        ->where('status', 'pending') // purchase requests are pending orders
        ->latest()
        ->get();

    return view('supervisor.orders', compact('orders'));
}
public function approveOrder(Order $order)
{
    if ($order->status !== 'pending') {
        return back()->with('error', 'Order already processed.');
    }

    DB::transaction(function () use ($order) {

        $order->update([
            'status' => 'approved'
        ]);

        // optional future stock logic goes here
    });

    return back()->with('success', 'Order approved successfully.');
}
public function history()
{
    $orders = Order::with(['user', 'items'])
        ->whereIn('status', ['approved', 'delivered', 'cancelled'])
        ->latest()
        ->get();

    return view('supervisor.history', compact('orders'));
}
}