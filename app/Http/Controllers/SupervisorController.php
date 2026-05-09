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
    $pendingOrders = Order::where('status', 'pending')->count();
    $approvedOrders = Order::where('status', 'approved')->count();

    $adjustments = ItemAdjustment::with(['item', 'user'])
        ->where('status', 'pending')
        ->latest()
        ->get();

    $pendingAdjustments = $adjustments->count();

    // ===========================
    // REAL SALES FROM order_items
    // ===========================
    $sales = DB::table('order_menu_items')
        ->join('orders', 'orders.order_id', '=', 'order_menu_items.order_id')
        ->join('menu_items', 'menu_items.menu_id', '=', 'order_menu_items.menu_id')
        ->selectRaw('
            MONTH(orders.created_at) as month,
            menu_items.menu_name,
            SUM(order_menu_items.quantity) as total_sold
        ')
        ->where('orders.status', 'approved')
        ->groupBy('month', 'menu_items.menu_id', 'menu_items.menu_name')
        ->get();

    $menuNames = $sales->pluck('item_name')->unique();

    $chartData = [];

    foreach ($menuNames as $name) {

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
        $adjustment = ItemAdjustment::findOrFail($id);
        $item = Item::findOrFail($adjustment->item_id);

        if ($item->count < $adjustment->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $item->count -= $adjustment->quantity;
        $item->save();

        $adjustment->status = 'approved';
        $adjustment->save();

        return back()->with('success', 'Adjustment approved successfully.');
    }

    // =========================
    // REJECT ADJUSTMENT
    // =========================
    public function rejectAdjustment($id)
    {
        $adjustment = ItemAdjustment::findOrFail($id);

        $adjustment->status = 'rejected';
        $adjustment->save();

        return back()->with('success', 'Adjustment rejected.');
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
}