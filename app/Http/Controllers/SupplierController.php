<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /* ================= ADMIN ================= */

    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.suppliers', compact('suppliers'));
    }

    public function create()
{
    return view('admin.create_supplier');
}

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_number' => 'required|string|max:50',
            'status' => 'required|string'
        ]);

        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'supplier_number' => $request->supplier_number,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier added successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.edit_supplier', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_number' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'supplier_number' => $request->supplier_number,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return back()->with('success', 'Supplier deleted successfully.');
    }

    /* ================= SUPERVISOR ================= */

    public function supervisorIndex()
    {
        $suppliers = Supplier::all();
        return view('supervisor.suppliers', compact('suppliers'));
    }

    /* ================= MANAGER ================= */

    public function managerIndex()
    {
        $suppliers = Supplier::all();
        return view('manager.suppliers', compact('suppliers'));
    }
}