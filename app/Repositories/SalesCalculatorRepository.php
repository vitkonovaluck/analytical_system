<?php
namespace App\Repositories;

use App\Models\LinkerOrderProduct;
use Illuminate\Support\Collection;

class SalesCalculatorRepository
{
    public function calculateSalesMetrics(int $linkerProductId): array
    {
        $sales = LinkerOrderProduct::with('order')
            ->where('product_id', $linkerProductId)
            ->get();

        return [
            'total_sales' => $this->calculateTotalSales($sales),
            'avg_sales_7d' => $this->calculate7DayAverage($sales),
            'sales_by_source' => $this->groupSalesBySource($sales),
        ];
    }

    protected function calculateTotalSales(Collection $sales): int
    {
        return $sales->sum('quantity');
    }

    protected function calculate7DayAverage(Collection $sales): float
    {
        $lastWeekSales = $sales->filter(fn($s) =>
            $s->order && $s->order->date > now()->subDays(7)
        )->sum('quantity');

        return round($lastWeekSales / 7, 2);
    }

    protected function groupSalesBySource(Collection $sales): array
    {
        return $sales->groupBy(fn($s) => $s->order?->source ?: 'unknown')
            ->map->sum('quantity')
            ->toArray();
    }
}
