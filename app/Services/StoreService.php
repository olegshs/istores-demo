<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class StoreService
{
    private UserService $userService;
    private CategoryService $categoryService;
    private ProductService $productService;

    public function __construct(UserService $userService, CategoryService $categoryService, ProductService $productService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * @return Collection|self[]
     */
    public function getStoreList(): Collection|array
    {
        $usersWithProducts = User::query()
            ->whereHas('products')
            ->orderBy('name')
            ->get();

        return $usersWithProducts->map(
            fn(User $user) => $this->getStoreById($user->id)
        );
    }

    public function getStoreById(int $storeId): ?Store
    {
        return Cache::remember(
            $this->getStoreByIdCacheKey($storeId),
            now()->addMinutes(10),
            fn() => $this->loadStoreById($storeId)
        );
    }

    public function getStoreByIdCacheClear(int $storeId): void
    {
        Cache::forget($this->getStoreByIdCacheKey($storeId));
    }

    private function getStoreByIdCacheKey(int $storeId): string
    {
        return "StoreService.StoreById.{$storeId}";
    }

    private function loadStoreById(int $storeId): ?Store
    {
        $user = $this->userService->getUserById($storeId);
        if (!$user) {
            return null;
        }

        $categories = $this->categoryService
            ->orderBy('name')
            ->getCategoryListByStoreId($user->id)
            ->map(function (Category $category) use ($user) {
                $category['products_count'] = $this->productService->getProductCountByStoreId($user->id, [$category->id]);
                return $category;
            })
            ->all();

        $store = new Store();
        $store->setId($user->id);
        $store->setInfo($user->toArray());
        $store->setCategories($categories);

        return $store;
    }
}
