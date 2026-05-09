<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'branch',
        'total_price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ FIXED: SUPPLIES RELATION (order_items)
    public function items()
    {
        return $this->belongsToMany(
            Item::class,
            'order_items',
            'order_id',
            'item_id'
        )->withPivot('quantity', 'price')
         ->withTimestamps();
    }
}