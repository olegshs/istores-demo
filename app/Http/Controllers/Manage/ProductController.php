<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AuthHelper;
use App\Http\Helpers\Pagination;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $storeId = AuthHelper::getStoreId();

        return Inertia::render('Manage/Products/Index', [
            'products' => Pagination::make(
                $this->productService->getProductCountByStoreId($storeId),
                fn($page, $perPage) => $this->productService
                    ->orderBy('id', 'desc')
                    ->forPage($page, $perPage)
                    ->getProductListByStoreId($storeId, null, ['categories'])
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Manage/Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request): RedirectResponse
    {
        $storeId = AuthHelper::getStoreId();
        $product = $this->productService->createProduct($storeId, $request->all());

        return to_route('manage.products.edit', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        $storeId = AuthHelper::getStoreId();

        return Inertia::render('Manage/Products/Edit', [
            'product' => $product->load('categories'),
            'all_categories' => $this->categoryService->getCategoryListByStoreId($storeId),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, ProductUpdateRequest $request): RedirectResponse
    {
        $this->productService->updateProduct($product, $request->all());

        return to_route('manage.products.edit', $product->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->deleteProduct($product);

        return to_route('manage.products.index');
    }
}
