<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AuthHelper;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CurrentStoreController extends Controller
{
    private StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * @throws \Exception
     */
    public function change(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $storeId = (int)$request->input('id');
        $store = $this->storeService->getStoreById($storeId);
        if (!$store) {
            abort(Response::HTTP_NOT_FOUND, "Store #{$storeId} not found.");
        }

        AuthHelper::setStoreId($store->getId());

        return response()->json($store);
    }
}
