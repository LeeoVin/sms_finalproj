<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'menu_id',
        'quantity',
        'price',
        'total',
        'branch'
    ];

    public function menu()
    {
        return $this->belongsTo(MenuItem::class, 'menu_id', 'menu_id');
    }
}