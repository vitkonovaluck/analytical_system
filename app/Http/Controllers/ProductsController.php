<?php

namespace App\Http\Controllers;

use App\Models\FirmaCatalog;
use App\Models\FirmaProduct;
use App\Models\LinkerOrderProduct;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $catalogId = $request->input('catalog_id');

        $catalogs = FirmaCatalog::all();

        $query = FirmaProduct::with('catalog', 'linkerProduct')
            ->when($catalogId, fn($q) => $q->where('catalog_id', $catalogId))
            ->limit(10000);

        $products = $query->get()->map(function ($product) {
            $linker = $product->linkerProduct;

            $sales = LinkerOrderProduct::where('product_id', optional($linker)->id)->get();

            $totalSales = $sales->sum('quantity');
            $avgSales7d = $sales->filter(fn($s) =>
                $s->order && $s->order->date > now()->subDays(7)
            )->sum('quantity');

            $bySources = $sales->groupBy(fn($s) => $s->order?->source)
                ->map(fn($group) => $group->sum('quantity'))
                ->toArray();

            return [
                'firma_id' => $product->id,
                'linker_id' => $linker?->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'ean' => $product->ean,
                'firma_quantity' => $product->quantity,
                'linker_quantity' => $linker?->quantity,
                'firma_price' => $product->price,
                'linker_price' => $linker?->price,
                'total_sales' => $totalSales,
                'avg_sales_7d' => $avgSales7d,
                'sales_by_source' => $bySources,
            ];
        });

        return view('products.index', compact('products', 'catalogs', 'catalogId'));
    }
}
