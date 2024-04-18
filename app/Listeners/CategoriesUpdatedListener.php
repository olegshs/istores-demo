<?php

namespace App\Listeners;

use App\Events\CategoriesUpdated;
use App\Services\StoreService;

class CategoriesUpdatedListener
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
    public function handle(CategoriesUpdated $event): void
    {
        $storeId = $event->getCategory()->store_id;
        $this->storeService->getStoreByIdCacheClear($storeId);
    }
}
