<?php

namespace App\Service;

use App\Models\LinkerOrder;
use App\Models\LinkerProduct;
use Carbon\Carbon;

class LinkerService
{
    public function getProducts()
    {
        $products = [];

        LinkerProduct::with('firmaProduct')
            ->chunk(1000, function ($chunk) use (&$products) {
                foreach ($chunk as $product) {
                    $products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'ean' => $product->ean,
                        'price' => $product->price,
                        'quantity' => $product->quantity,
                        'firma_product_id' => $product->firma_product_id,
                        'last_sync' => now()->toIso8601String(),
                    ];
                }
            });

        return $products;

    }

    public function getOrders()
    {

        $linker_orders = collect();

        LinkerOrder::query()
            ->orderBy('date', 'desc')
            ->take(500) // Обмеження для імітації
            ->chunk(200, function ($orders) use (&$linker_orders) {
                $chunkResult = $orders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'source' => $order->source,
                        'total' => $order->total,
                        'date' => Carbon::parse($order->date)->format('Y-m-d H:i:s'),
                    ];
                });

                $linker_orders = $linker_orders->merge($chunkResult);
            });

        return $linker_orders;
    }

    public function getOrderProducts()
    {

        $linker_order_products = collect();

        LinkerOrder::query()
            ->with('orderProducts.product') // eager load
            ->take(200)
            ->chunk(100, function ($orders) use (&$linker_order_products) {
                $chunkData = $orders->flatMap(function ($order) {
                    return $order->orderProducts->map(function ($orderProduct) use ($order) {
                        return [
                            'order_id' => $order->id,
                            'product_id' => $orderProduct->product_id,
                            'price' => $orderProduct->price,
                            'quantity' => $orderProduct->quantity,
                            'product_name' => $orderProduct->product->name ?? 'N/A',
                        ];
                    });
                });

                $linker_order_products = $linker_order_products->merge($chunkData);
            });

        return $linker_order_products;
    }

}
