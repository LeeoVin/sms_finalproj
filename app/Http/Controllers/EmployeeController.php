<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', '!=', 'admin')->get();
        return view('admin.employees', compact('employees'));
    }

    public function create()
    {
        return view('admin.create_employee');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'branch' => 'required|string|max:255',
        ]);

        User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch' => $request->branch,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee added successfully!');
    }

    public function edit(User $employee)
    {
        return view('admin.edit_employee', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|string|max:100',
            'branch' => 'required|string|max:255',
        ]);

        $employee->update([
            'username' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'branch' => $request->branch,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}