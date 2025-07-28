<?php

namespace App\Service;

use App\Models\FirmaCatalog;
use App\Models\FirmaProduct;

class FirmaService
{
    public function getProducts()
    {

        return FirmaProduct::query()
            ->with('catalog')
            ->take(1000) // Обмеження для імітації
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'ean' => $product->ean,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'catalog_id' => $product->catalog_id,
                    'last_updated' => now()->toIso8601String(),
                ];
            });
    }


    public function getCatalogs()
    {

        return FirmaCatalog::all()
            ->map(function ($catalog) {
                return [
                    'id' => $catalog->id,
                    'name' => $catalog->name,
                    'product_count' => $catalog->products()->count(),
                ];
            });
    }
}
