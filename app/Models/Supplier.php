<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'supplier_number',
        'status'
    ];

    /**
     * NOTE:
     * We remove items() relationship because:
     * - Suppliers should NOT own menu items
     * - They will instead supply RAW MATERIALS in future phase
     */

    // Future use:
    // public function supplies()
    // {
    //     return $this->hasMany(Supply::class);
    // }
}