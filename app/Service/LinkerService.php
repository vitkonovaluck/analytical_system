<?php

namespace App\Service;

use App\Models\LinkerOrder;
use App\Models\LinkerProduct;
use Carbon\Carbon;
use DateTimeInterface;

class LinkerService
{
    public function getProducts()
    {
        return LinkerProduct::query()
            ->with('firmaProduct')
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
                    'firma_product_id' => $product->firma_product_id,
                    'last_sync' => now()->toIso8601String(),
                ];
            });
    }

    public function getOrders()
    {

        return LinkerOrder::query()
            ->orderBy('date', 'desc')
            ->take(500) // Обмеження для імітації
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'source' => $order->source,
                    'total' => $order->total,
                    'date' => Carbon::parse($order->date)->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function getOrderProducts()
    {

        return LinkerOrder::query()
            ->with('orderProducts.product')
            ->take(200) // Обмеження для імітації
            ->get()
            ->flatMap(function ($order) {
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
    }

    protected function formatDate($date)
    {
        try {
            return Carbon::parse($date)->toIso8601String();
        } catch (\Exception $e) {
            \Log::error('Date parsing error', ['error' => $e->getMessage()]);
            return Carbon::now()->toIso8601String();
        }
    }
}
