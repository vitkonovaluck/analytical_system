<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkerProduct extends Model
{
    /** @use HasFactory<\Database\Factories\LinkerProductFactory> */
    use HasFactory;

    protected $table = 'linker_products';

    protected $fillable=[
        'name',
        'sku',
        'ean',
        'price',
        'quantity',
    ];

    public function firmaProduct()
    {
        return $this->belongsTo(FirmaProduct::class, 'firma_product_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(LinkerOrderProduct::class, 'product_id');
    }
}
