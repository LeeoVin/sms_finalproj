<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{
   // SaleController.php
public function store(Request $request)
{
    Sale::create([
        'menu_id' => $request->menu_id,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'total' => $request->price * $request->quantity,
        'branch' => session('branch'),
    ]);

    return back()->with('success', 'Sale recorded');
}
}
