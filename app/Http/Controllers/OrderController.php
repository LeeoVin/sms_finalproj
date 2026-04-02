<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        // Assuming 'supplier' and 'employee' relations exist in Order model
        $orders = Order::with(['supplier', 'employee'])->get();
        return view('admin.orders', compact('orders'));
    }
}