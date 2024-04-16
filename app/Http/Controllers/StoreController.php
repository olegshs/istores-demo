<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Store;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\StoreService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class StoreController extends Controller
{
    private StoreService $storeService;
    private ProductService $productService;
    private OrderService $orderService;

    public function __construct(StoreService $storeService, ProductService $productService, OrderService $orderService)
    {
        $this->storeService = $storeService;
        $this->productService = $productService;
        $this->orderService = $orderService;
    }

    public function index(): Response
    {
        $stores = $this->storeService->getStoreList();

        return Inertia::render('Stores/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'stores' => $stores,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function products(int $storeId): Response
    {
        $store = $this->getStore($storeId);

        $products = $this->productService
            ->orderBy('id', 'desc')
            ->getProductListByStoreId($store->getId());

        $order = $this->getOrder($storeId);

        return Inertia::render('Stores/ProductList', [
            'store' => $store,
            'products' => $products,
            'order' => $order,
        ]);
    }

    public function category(int $storeId, Category $category): Response
    {
        $store = $this->getStore($storeId);

        $products = $this->productService
            ->orderBy('id', 'desc')
            ->getProductListByStoreId($storeId, [$category->id]);

        $order = $this->getOrder($storeId);

        return Inertia::render('Stores/ProductList', [
            'store' => $store,
            'category' => $category,
            'products' => $products,
            'order' => $order,
        ]);
    }

    private function getStore(int $storeId): Store
    {
        $store = $this->storeService->getStoreById($storeId);
        if (!$store) {
            abort(HttpResponse::HTTP_NOT_FOUND, "Store {$storeId} not found.");
        }

        return $store;
    }

    private function getOrder(int $storeId): ?Order
    {
        $sessionId = Session::getId();
        if (!$sessionId) {
            return null;
        }

        return $this->orderService->getOrNewOrderBySessionId($storeId, $sessionId, OrderStatus::New, [
            'products' => function (HasMany $query) {
                $query
                    ->orderBy('id')
                    ->with('product');
            },
        ]);
    }
}
