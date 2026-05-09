<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Item;
use App\Models\Order;
use App\Models\BranchStock;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ========================
        // BASIC STATS
        // ========================
        $totalSuppliers = Supplier::count();
        $totalItems = Item::count();
        $totalOrders = Order::where('type', 'purchase')->count();

        $pendingOrders = Order::where('type', 'purchase')->where('status', 'pending')->count();
        $approvedOrders = Order::where('type', 'purchase')->where('status', 'approved')->count();
        $cancelledOrders = Order::where('type', 'purchase')->where('status', 'cancelled')->count();

        // ========================
        // TOTAL SALES (REVENUE)
        // ========================
        $totalSales = DB::table('sales')
    ->sum('total') ?? 0;
        // ========================
        // MONTHLY SALES (REVENUE)
        // ========================
        $monthlySales = DB::table('sales')
    ->select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

        $salesData = array_fill(1, 12, 0);

        foreach ($monthlySales as $sale) {
            $salesData[$sale->month] = $sale->total;
        }

        // ========================
        // LOW STOCK ALERT
        // ========================
        $lowStockItems = DB::table('supply_batches')
            ->join('items', 'items.item_id', '=', 'supply_batches.item_id')
            ->select(
                'items.item_name',
                'supply_batches.branch',
                DB::raw('SUM(supply_batches.quantity_remaining) as stock')
            )
            ->groupBy('items.item_name', 'supply_batches.branch')
            ->having('stock', '<=', 5)
            ->get();

        // ========================
        // RECENT ORDERS
        // ========================
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSuppliers',
            'totalItems',
            'totalOrders',
            'pendingOrders',
            'approvedOrders',
            'cancelledOrders',
            'totalSales',
            'salesData',
            'lowStockItems',
            'recentOrders'
        ));
    }
}