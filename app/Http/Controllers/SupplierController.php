<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier; // Make sure you have a Supplier model

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers
     */
    public function index()
    {
        $suppliers = Supplier::all(); // Fetch all suppliers
        return view('admin.suppliers', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier
     */
    public function create()
    {
        return view('admin.create_supplier');
    }

    /**
     * Store a newly created supplier in storage
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status' => 'required|in:In Stock,Out of Stock',
        ]);

        // Create supplier
        Supplier::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'status' => $request->status,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }

    /**
     * Show the form for editing the specified supplier
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.edit_supplier', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status' => 'required|in:In Stock,Out of Stock',
        ]);

        // Update supplier
        $supplier->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'status' => $request->status,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified supplier from storage
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}