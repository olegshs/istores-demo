<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Store;
use App\Services\OrderService;
use App\Services\StoreService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    private StoreService $storeService;
    private OrderService $orderService;

    /**
     * @param StoreService $storeService
     * @param OrderService $orderService
     */
    public function __construct(StoreService $storeService, OrderService $orderService)
    {
        $this->storeService = $storeService;
        $this->orderService = $orderService;
    }

    public function checkout(int $storeId): Response
    {
        $store = $this->getStore($storeId);
        $order = $this->getOrder($storeId);

        return Inertia::render('Checkout', [
            'store' => $store,
            'order' => $order,
        ]);
    }

    public function pay(int $storeId, CheckoutRequest $request): RedirectResponse
    {
        $store = $this->getStore($storeId);
        $order = $this->getOrder($storeId);

        $this->orderService->updateOrder($order, OrderStatus::Paid, $request->all());

        return to_route('stores.cart.thanks', [$store->getId(), $order->id]);
    }

    public function thanks(int $storeId, Order $order): Response
    {
        $store = $this->getStore($storeId);

        return Inertia::render('Thanks', [
            'store' => $store,
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
            'details',
            'products' => function (HasMany $query) {
                $query
                    ->orderBy('id')
                    ->with('product');
            },
        ]);
    }
}
