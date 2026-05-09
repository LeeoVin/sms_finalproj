<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'status',
        'branch',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ FIXED RELATION: menu_items (NOT items)
    public function menuItems()
    {
        return $this->belongsToMany(
            MenuItem::class,
            'order_menu_items',
            'order_id',
            'menu_id'
        )->withPivot('quantity', 'price')
         ->withTimestamps();
    }
}