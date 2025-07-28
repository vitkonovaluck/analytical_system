<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaCatalog extends Model
{
    /** @use HasFactory<\Database\Factories\FirmaCatalogFactory> */
    use HasFactory;

    protected $table = 'firma_catalogs';

    protected $fillable=['name'];

    public function products()
    {
        return $this->hasMany(FirmaProduct::class, 'catalog_id');
    }
}
