<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nfe_invoice_id',
        'sale_item_id',
        'item_number',
    ];

    public function invoice()
    {
        return $this->belongsTo(NfeInvoice::class, 'nfe_invoice_id');
    }

    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }
}


