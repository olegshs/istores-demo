<?php

namespace App\Http\Middleware;

use App\Http\Helpers\AuthHelper;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    private StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();

        $storeId = AuthHelper::getStoreId();

        $store = null;
        if ($storeId) {
            $store = $this->storeService->getStoreById($storeId);
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'is_admin' => $user?->isAdmin() ?? false,
            ],
            'store' => $store,
        ];
    }
}
