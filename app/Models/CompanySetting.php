<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'trade_name',
        'cnpj',
        'ie',
        'im',
        'tax_regime',
        'cnae',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'city_ibge_code',
        'state',
        'zip_code',
        'phone',
        'email',
        'nfe_environment',
        'nfe_series',
        'nfe_last_number',
        'nfe_cert_path',
    ];
}


