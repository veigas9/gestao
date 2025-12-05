<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_setting_id',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function companySetting()
    {
        return $this->belongsTo(CompanySetting::class);
    }
}
