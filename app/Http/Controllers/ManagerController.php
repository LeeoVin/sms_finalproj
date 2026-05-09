<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Item;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $menus = MenuItem::all();

        $miscItems = Item::where(
            'category',
            'Miscellaneous'
        )->get();

        return view('manager.dashboard', compact(
            'menus',
            'miscItems'
        ));
    }
}