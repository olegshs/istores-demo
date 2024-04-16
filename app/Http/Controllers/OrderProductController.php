<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class OrderProductController extends Controller
{
    private OrderService $orderService;
    private ProductService $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $storeId): JsonResponse
    {
        $order = $this->getOrder($storeId);
        $products = $this->orderService->getOrderProducts($order);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['integer', 'required'],
        ]);

        $productId = (int)$request->input('product_id');
        $product = $this->productService->getProductById($productId);
        if (!$product) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, "Product #{$productId} not found.");
        }

        $order = $this->getOrder($product->store_id);
        $orderProduct = $this->orderService->getOrCreateOrderProduct($order, $product);

        return response()->json($orderProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderProduct $orderProduct, Request $request): JsonResponse
    {
        //Gate::authorize('order-product-update', $orderProduct);

        $request->validate([
            'quantity' => ['integer', 'min:1'],
        ]);

        $this->orderService->updateOrderProduct($orderProduct, $request->all());

        return response()->json($orderProduct);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $orderProduct): JsonResponse
    {
        //Gate::authorize('order-product-update', $orderProduct);

        $this->orderService->deleteOrderProduct($orderProduct);

        return response()->json($orderProduct->id);
    }

    private function getOrder(int $storeId): Order
    {
        $sessionId = Session::getId();
        return $this->orderService->getOrNewOrderBySessionId($storeId, $sessionId, OrderStatus::New);
    }
}
