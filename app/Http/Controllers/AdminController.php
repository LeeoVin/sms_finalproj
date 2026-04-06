<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Supplier;


class AdminController extends Controller
{
   public function dashboard()
{
    $employees = \App\Models\Employee::all();
    $suppliers = \App\Models\Supplier::all();

    return view('admin.dashboard', compact('employees', 'suppliers'));
}
}