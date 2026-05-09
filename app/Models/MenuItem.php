<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name',
        'category',
        'price'
    ];

    public $timestamps = true;

    public function supplies()
    {
        return $this->belongsToMany(
            Item::class,
            'menu_item_supplies',
            'menu_id',
            'item_id'
        )->withPivot('quantity_needed');
    }
}