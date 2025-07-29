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

    public function getFormattedProducts(?int $catalogId): Collection
    {
        return FirmaProduct::with('catalog', 'linkerProduct')
            ->when($catalogId, fn($q) => $q->where('catalog_id', $catalogId))
            ->limit(10000)
            ->get()
            ->map(function ($product) {
                $baseData = $this->formatProduct($product);

                // Додаємо метрики продажів тільки якщо є зв'язаний linkerProduct
                if ($product->linkerProduct) {
                    $salesData = $this->salesCalculator->calculateSalesMetrics($product->linkerProduct->id);
                    return array_merge($baseData, $salesData);
                }

                // Повертаємо базові дані з нульовими значеннями для продажів
                return array_merge($baseData, [
                    'total_sales' => 0,
                    'avg_sales_7d' => 0,
                    'sales_by_source' => []
                ]);
            });
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
