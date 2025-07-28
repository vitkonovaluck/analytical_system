<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkerOrderProduct extends Model
{
    /** @use HasFactory<\Database\Factories\LinkerOrderProductFactory> */
    use HasFactory;

    protected $table = 'linker_order_products';

    protected $fillable=[
        'price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(LinkerOrder::class,'order_id');
    }

    public function product()
    {
        return $this->belongsTo(LinkerProduct::class, 'product_id');
    }
}
