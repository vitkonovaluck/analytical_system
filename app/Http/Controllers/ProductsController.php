<?php

namespace App\Http\Controllers;

use App\Service\ProductDataService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(
        protected ProductDataService $productService
    ) {}

    public function __invoke(Request $request)
    {
        $catalogId = $request->input('catalog_id');
        $data = $this->productService->getProductsData($catalogId);

        return view('products.index', $data);
    }
}
