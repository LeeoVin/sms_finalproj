<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\MenuItem;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu_items,menu_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // ALWAYS get price from DB (never from request)
        $menu = MenuItem::findOrFail($request->menu_id);

        $price = $menu->price;
        $total = $price * $request->quantity;

        Sale::create([
            'menu_id' => $menu->menu_id,
            'quantity' => $request->quantity,
            'price' => $price,
            'total' => $total,
            'branch' => session('branch'),
        ]);

        return back()->with('success', 'Sale recorded successfully.');
    }
}