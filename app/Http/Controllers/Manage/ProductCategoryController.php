<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResponse
    {
        return response()->json(
            $this->productService->getProductCategories($product)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, ProductCategoryUpdateRequest $request): JsonResponse
    {
        $categoryIds = $request->input('category_ids');
        $this->productService->addProductCategories($product, $categoryIds);

        return response()->json(
            $this->productService->getProductCategories($product)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, ProductCategoryUpdateRequest $request): JsonResponse
    {
        $categoryIds = $request->input('category_ids');
        $this->productService->replaceProductCategories($product, $categoryIds);

        return response()->json(
            $this->productService->getProductCategories($product)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductCategoryUpdateRequest $request): JsonResponse
    {
        $categoryIds = $request->input('category_ids');
        $this->productService->deleteProductCategories($product, $categoryIds);

        return response()->json(
            $this->productService->getProductCategories($product)
        );
    }
}
