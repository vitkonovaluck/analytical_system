<?php
namespace App\Repositories;

use App\Models\FirmaCatalog;
use App\Models\FirmaProduct;
use Illuminate\Support\Collection;

class ProductRepository
{

    protected SalesCalculatorRepository $salesCalculator;

    public function __construct(SalesCalculatorRepository $salesCalculator)
    {
        $this->salesCalculator = $salesCalculator;
    }

    public function getAllCatalogs()
    {
        return FirmaCatalog::all();
    }

    public function getFormattedProducts(?int $catalogId = null)
    {
        $query = FirmaProduct::with('catalog', 'linkerProduct')
            ->when($catalogId, fn($q) => $q->where('catalog_id', $catalogId));

        $transformer = fn($product) => array_merge(
            $this->formatProduct($product),
            $product->linkerProduct
                ? $this->salesCalculator->calculateSalesMetrics($product->linkerProduct->id)
                : [
                'total_sales' => 0,
                'avg_sales_7d' => 0,
                'sales_by_source' => []
            ]
        );

        return$query->paginate(50)->through($transformer);
    }

    protected function formatProduct($product): array
    {
        return [
            'firma_id' => $product->id,
            'linker_id' => $product->linkerProduct?->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'ean' => $product->ean,
            'firma_quantity' => $product->quantity,
            'linker_quantity' => $product->linkerProduct?->quantity,
            'firma_price' => $product->price,
            'linker_price' => $product->linkerProduct?->price,
        ];
    }
}
