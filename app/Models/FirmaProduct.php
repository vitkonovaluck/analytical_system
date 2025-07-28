<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaProduct extends Model
{
    /** @use HasFactory<\Database\Factories\FirmaProductFactory> */
    use HasFactory;

    protected $table = 'firma_products';

    protected $fillable=[
        'name',
        'sku',
        'ean',
        'price',
        'quantity',
    ];

    public function catalog()
    {
        return $this->belongsTo(FirmaCatalog::class,  'firma_catalog_id');
    }

    public function linkerProduct()
    {
        return $this->hasOne(\App\Models\LinkerProduct::class, 'firma_product_id', 'id');
    }
}
