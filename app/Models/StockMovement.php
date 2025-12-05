<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'unit_price',
        'previous_stock',
        'resulting_stock',
        'movement_date',
        'notes',
    ];

    protected $casts = [
        'movement_date' => 'datetime',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
