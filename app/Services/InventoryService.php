<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\BranchStock;

class InventoryService
{
    public static function deductMenuItem($menuId, $qty, $branch)
    {
        $menu = MenuItem::with('supplies')->find($menuId);

        if (!$menu) {
            throw new \Exception("Menu not found");
        }

        foreach ($menu->supplies as $supply) {

            $neededQty = $supply->pivot->quantity_needed * $qty;

            $stock = BranchStock::firstOrCreate(
                [
                    'item_id' => $supply->item_id,
                    'branch' => $branch
                ],
                [
                    'stock' => 0
                ]
            );

            if ($stock->stock < $neededQty) {
                throw new \Exception("Insufficient stock for: " . $supply->item_name);
            }

            $stock->stock -= $neededQty;
            $stock->save();
        }
    }
}