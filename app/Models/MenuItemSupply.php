<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemSupply extends Model
{
    protected $table = 'menu_item_supplies';

    protected $fillable = [
        'menu_id',
        'item_id',
        'quantity_needed'
    ];

    // =========================
    // MENU ITEM
    // =========================
    public function menuItem()
    {
        return $this->belongsTo(
            MenuItem::class,
            'menu_id',
            'menu_id'
        );
    }

    // =========================
    // SUPPLY ITEM
    // =========================
    public function supplyItem()
    {
        return $this->belongsTo(
            Item::class,
            'item_id',
            'item_id'
        );
    }
}