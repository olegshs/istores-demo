<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AuthHelper;
use App\Http\Helpers\Pagination;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $storeId = AuthHelper::getStoreId();

        $status = [
            OrderStatus::Paid,
            OrderStatus::Processing,
            OrderStatus::Completed,
        ];

        return Inertia::render('Manage/Orders/Index', [
            'orders' => Pagination::make(
                $this->orderService->getOrderCountByStoreId($storeId, $status),
                fn($page, $perPage) => $this->orderService
                    ->orderBy('id', 'desc')
                    ->forPage($page, $perPage)
                    ->getOrderListByStoreId($storeId, $status, ['details'])
            ),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
