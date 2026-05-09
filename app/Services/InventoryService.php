<?php

namespace App\Services;

use App\Models\BranchStock;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Deduct SUPPLIES when Purchase Order is made
     */
    public static function deductSupply($itemId, $quantity, $branch)
    {
        $stock = BranchStock::where('item_id', $itemId)
            ->where('branch', $branch)
            ->first();

        if (!$stock) {
            throw new \Exception("No stock record found for this item in branch.");
        }

        if ($stock->stock < $quantity) {
            throw new \Exception("Not enough stock available.");
        }

        $stock->stock -= $quantity;
        $stock->save();
    }

    /**
     * (Optional later) Deduct MENU ingredients
     */
    public static function deductMenuItem($menuId, $quantity, $branch)
    {
        // you already used this earlier, leave if needed
    }
}