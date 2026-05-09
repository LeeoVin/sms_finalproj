<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Item;

class MenuController extends Controller
{
    public function index()
{
    $menus = MenuItem::with('supplies')->get();

    $items = Item::all();

    return view('admin.menu', compact(
        'menus',
        'items'
    ));
}

    public function store(Request $request)
{
    $request->validate([
        'menu_name' => 'required',
        'category' => 'required',
        'price' => 'required|numeric|min:0',
    ]);

    // =========================
    // CREATE / UPDATE MENU
    // =========================
    $menu = MenuItem::updateOrCreate(
        [
            'menu_id' => $request->menu_id
        ],
        [
            'menu_name' => $request->menu_name,
            'category' => $request->category,
            'price' => $request->price,
        ]
    );

    // =========================
    // REMOVE OLD SUPPLIES
    // =========================
    DB::table('menu_item_supplies')
        ->where('menu_id', $menu->menu_id)
        ->delete();

    // =========================
    // SAVE NEW SUPPLIES
    // =========================
    if ($request->supply_item_id) {

        foreach ($request->supply_item_id as $index => $itemId) {

            if (!$itemId) {
                continue;
            }

            DB::table('menu_item_supplies')->insert([
                'menu_id' => $menu->menu_id,
                'item_id' => $itemId,
                'quantity_needed' => $request->supply_quantity[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return back()->with('success', 'Menu saved successfully.');
}

    public function destroy($id)
    {
        MenuItem::where('menu_id', $id)->delete();

        return back()->with('success', 'Menu item deleted.');
    }

    
}