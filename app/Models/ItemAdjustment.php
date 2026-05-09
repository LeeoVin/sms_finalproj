<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAdjustment extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'branch',
        'quantity',
        'reason',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}