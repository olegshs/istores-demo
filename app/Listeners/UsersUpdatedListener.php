<?php

namespace App\Listeners;

use App\Events\UsersUpdated;
use App\Services\StoreService;

class UsersUpdatedListener
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
    public function handle(UsersUpdated $event): void
    {
        $storeId = $event->getUser()->id;
        $this->storeService->getStoreByIdCacheClear($storeId);
    }
}
