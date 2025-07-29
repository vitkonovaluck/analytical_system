<?php

namespace App\Service;

use App\Models\FirmaCatalog;
use App\Models\FirmaProduct;

class FirmaService
{
    public function getProducts()
    {

        $products = [];

        FirmaProduct::with('catalog')
            ->chunk(1000, function ($chunk) use (&$products) {
                foreach ($chunk as $product) {
                    $products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'ean' => $product->ean,
                        'price' => $product->price,
                        'quantity' => $product->quantity,
                        'catalog_id' => $product->catalog_id,
                        'catalog_name' => $product->catalog->name ?? null,
                        'last_updated' => $product->updated_at->toIso8601String(),
                    ];
                }
            });

        return $products;
    }


    public function getCatalogs()
    {

        $result = collect();

        FirmaCatalog::chunk(200, function ($catalogs) use (&$result) {
            $chunkResult = $catalogs->map(function ($catalog) {
                return [
                    'id' => $catalog->id,
                    'name' => $catalog->name,
                    'product_count' => $catalog->products()->count(),
                ];
            });

            $result = $result->merge($chunkResult);
        });

        return $result;
    }
}
