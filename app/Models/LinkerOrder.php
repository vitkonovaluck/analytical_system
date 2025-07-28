<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkerOrder extends Model
{
    /** @use HasFactory<\Database\Factories\LinkerOrderFactory> */
    use HasFactory;

    protected $table = 'linker_orders';

    protected $fillable=[
        'source',
        'total',
        'date'
    ];

    public function orderProducts()
    {
        return $this->hasMany(LinkerOrderProduct::class, 'order_id');
    }
}
