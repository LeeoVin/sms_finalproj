<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Supplier;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $employeeCount = Employee::count();
        $supplierCount = Supplier::count();
        $orderCount = Order::count();

        return view('admin.dashboard', compact(
            'employeeCount',
            'supplierCount',
            'orderCount'
        ));
    }
}