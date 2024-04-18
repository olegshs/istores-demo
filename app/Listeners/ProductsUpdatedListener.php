<?php

namespace App\Listeners;

use App\Events\ProductsUpdated;
use App\Services\StoreService;

class ProductsUpdatedListener
{
    private StoreService $storeService;

    /**
     * Create the event listener.
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProductsUpdated $event): void
    {
        $storeId = $event->getProduct()->store_id;
        $this->storeService->getStoreByIdCacheClear($storeId);
    }
}
