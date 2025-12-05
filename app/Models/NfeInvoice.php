<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'environment',
        'status',
        'series',
        'number',
        'access_key',
        'protocol',
        'xml_path',
        'last_message',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function items()
    {
        return $this->hasMany(NfeItem::class);
    }
}


