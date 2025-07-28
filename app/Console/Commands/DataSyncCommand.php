<?php

namespace App\Console\Commands;

use App\Models\FirmaCatalog;
use App\Models\FirmaProduct;
use App\Models\LinkerOrder;
use App\Models\LinkerOrderProduct;
use App\Models\LinkerProduct;
use App\Service\FirmaService;
use App\Service\LinkerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataSyncCommand extends Command
{
     protected $signature = 'data:sync';
    protected $description = 'Synchronize data between Firma and Linker systems';

    public function handle(FirmaService $firma, LinkerService $linker)
    {
        $this->info('Starting data synchronization...');
        Log::info('Data sync started');

        try {
            DB::transaction(function () use ($firma, $linker) {
                // 1. Синхронізація каталогів
                $this->syncCatalogs($firma->getCatalogs());

                // 2. Синхронізація продуктів Firma
                $this->syncFirmaProducts($firma->getProducts());

                // 3. Синхронізація продуктів Linker
                $this->syncLinkerProducts($linker->getProducts());

                // 4. Синхронізація замовлень
                $this->syncOrders($linker->getOrders());

                // 5. Синхронізація продуктів замовлень
                $this->syncOrderProducts($linker->getOrderProducts());
            });

            $this->info('Synchronization completed successfully!');
            Log::info('Data sync completed');
        } catch (\Exception $e) {
            Log::error('Sync failed: '.$e->getMessage());
            $this->error('Error during synchronization: '.$e->getMessage());
        }
    }

    protected function syncCatalogs($catalogs)
    {
        foreach ($catalogs as $catalog) {
            FirmaCatalog::updateOrCreate(
                ['id' => $catalog['id']],
                ['name' => $catalog['name']]
            );
        }
        $this->info('Synced '.count($catalogs).' catalogs');
    }

    protected function syncFirmaProducts($products)
    {
        $count = 0;
        foreach ($products as $product) {
            FirmaProduct::updateOrCreate(
                ['id' => $product['id']],
                [
                    'name' => $product['name'],
                    'sku' => $product['sku'],
                    'ean' => $product['ean'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'catalog_id' => $product['catalog_id'],
                ]
            );
            $count++;
        }
        $this->info('Synced '.$count.' Firma products');
    }

    protected function syncLinkerProducts($products)
    {
        $count = 0;
        foreach ($products as $product) {
            LinkerProduct::updateOrCreate(
                ['id' => $product['id']],
                [
                    'name' => $product['name'],
                    'sku' => $product['sku'],
                    'ean' => $product['ean'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'firma_product_id' => $product['firma_product_id'],
                ]
            );
            $count++;
        }
        $this->info('Synced '.$count.' Linker products');
    }

    protected function syncOrders($orders)
    {
        $count = 0;
        foreach ($orders as $order) {
            LinkerOrder::updateOrCreate(
                ['id' => $order['id']],
                [
                    'source' => $order['source'],
                    'total' => $order['total'],
                    'date' => $order['date'],
                ]
            );
            $count++;
        }
        $this->info('Synced '.$count.' orders');
    }

    protected function syncOrderProducts($orderProducts)
    {
        $count = 0;
        foreach ($orderProducts as $op) {
            LinkerOrderProduct::updateOrCreate(
                [
                    'order_id' => $op['order_id'],
                    'product_id' => $op['product_id'],
                ],
                [
                    'price' => $op['price'],
                    'quantity' => $op['quantity'],
                ]
            );
            $count++;
        }
        $this->info('Synced '.$count.' order products');
    }

}
