<?php

namespace App\Service;

use App\Repositories\ProductRepository;
use App\Repositories\SalesCalculatorRepository;

class ProductDataService
{
    public function __construct(
        protected ProductRepository $productRepo,
        protected SalesCalculatorRepository $salesCalculator
    ) {}

    public function getProductsData(?int $catalogId): array
    {
        return [
            'products' => $this->productRepo->getFormattedProducts($catalogId),
            'catalogs' => $this->productRepo->getAllCatalogs(),
            'catalogId' => $catalogId
        ];
    }
}
