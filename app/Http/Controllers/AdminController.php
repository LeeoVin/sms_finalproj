<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

class AdminController extends Controller
{
    public function dashboard()
    {
        $suppliers = Supplier::all();
        return view('admin.dashboard', compact('suppliers'));
    }
}