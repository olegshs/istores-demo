<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function getOrderById(int $orderId): ?Order
    {
        /** @var Order $order */
        $order = Order::query()
            ->find($orderId);

        return $order;
    }

    public function getOrderBySessionId(int $storeId, string $sessionId, OrderStatus $status, array $withRelations = []): ?Order
    {
        /** @var Order $order */
        $order = Order::query()
            ->with($withRelations)
            ->where('store_id', '=', $storeId)
            ->where('session_id', '=', $sessionId)
            ->where('status', '=', $status)
            ->orderByDesc('id')
            ->first();

        return $order;
    }

    public function getOrNewOrderBySessionId(int $storeId, string $sessionId, OrderStatus $status, array $withRelations = []): Order
    {
        $order = $this->getOrderBySessionId($storeId, $sessionId, $status, $withRelations);
        if (!$order) {
            $order = new Order();
            $order->store_id = $storeId;
            $order->session_id = $sessionId;
            $order->status = OrderStatus::New;
        }

        return $order;
    }

    /**
     * @param Order $order
     * @param OrderStatus $status
     * @param array $orderDetailsData
     * @return void
     */
    public function updateOrder(Order $order, OrderStatus $status, array $orderDetailsData): void
    {
        $order->status = $status;
        $order->save();

        $orderDetails = $order->details;
        if (!$orderDetails) {
            $orderDetails = new OrderDetails();
        }

        $orderDetails->fill($orderDetailsData);
        $order->details()->save($orderDetails);
    }

    /**
     * @param Order $order
     * @param array $withRelations
     * @return Collection|Product
     */
    public function getOrderProducts(Order $order, array $withRelations = []): Collection|array
    {
        return $order->products()
            ->with($withRelations)
            ->orderBy('id')
            ->get();
    }

    /**
     * @param Order $order
     * @param Product $product
     * @param array $withRelations
     * @return OrderProduct|null
     */
    public function getOrderProduct(Order $order, Product $product, array $withRelations = []): ?OrderProduct
    {
        /** @var OrderProduct $orderProduct */
        $orderProduct = OrderProduct::query()
            ->with($withRelations)
            ->where('order_id', '=', $order->id)
            ->where('product_id', '=', $product->id)
            ->first();

        return $orderProduct;
    }

    /**
     * @param Order $order
     * @param Product $product
     * @return OrderProduct
     */
    public function getOrCreateOrderProduct(Order $order, Product $product): OrderProduct
    {
        if ($order->isDirty()) {
            $order->save();
        }

        $existingOrderProduct = $this->getOrderProduct($order, $product, ['order', 'product']);
        if ($existingOrderProduct) {
            return $existingOrderProduct;
        }

        $orderProduct = new OrderProduct();
        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $product->id;
        $orderProduct->price = $product->price;
        $orderProduct->quantity = 1;
        $orderProduct->save();

        $orderProduct->load(['order', 'product']);
        $order->load('products');

        return $orderProduct;
    }

    public function updateOrderProduct(OrderProduct $orderProduct, array $data): void
    {
        $orderProduct->fill($data);
        $orderProduct->save();
    }

    public function deleteOrderProduct(OrderProduct $orderProduct): void
    {
        $orderProduct->delete();
    }
}
