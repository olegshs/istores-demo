<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Collection;

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
        $store = $this->userService->getUserById($storeId);
        if (!$store) {
            return null;
        }

        $categories = $this->categoryService
            ->orderBy('name')
            ->getCategoryListByStoreId($store->id)
            ->map(function (Category $category) use ($store) {
                $category['products_count'] = $this->productService->getProductCountByStoreId($store->id, [$category->id]);
                return $category;
            })
            ->all();

        $data = new Store();
        $data->setId($store->id);
        $data->setInfo($store->toArray());
        $data->setCategories($categories);

        return $data;
    }
}
