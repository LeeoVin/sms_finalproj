<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStock extends Model
{
    protected $fillable = [
        'item_id',
        'branch',
        'stock'
    ];

   public function item()
{
    return $this->belongsTo(Item::class, 'item_id', 'item_id');
}
}