<?php

namespace App\Services;

use App\Events\CategoryCreated;
use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Models\Category;
use App\Services\Traits\PagingTrait;
use App\Services\Traits\SortingTrait;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    use SortingTrait;
    use PagingTrait;

    /**
     * @param int $storeId
     * @return int
     */
    public function getCategoryCountByStoreId(int $storeId): int
    {
        return Category::query()
            ->where('store_id', '=', $storeId)
            ->count();
    }

    /**
     * @param int $storeId
     * @return Collection|Category
     */
    public function getCategoryListByStoreId(int $storeId): Collection|array
    {
        $query = Category::query()
            ->where('store_id', '=', $storeId);

        $this->addSorting($query);
        $this->addPaging($query);

        return $query->get();
    }

    /**
     * @param int $categoryId
     * @return Category|null
     */
    public function getCategoryById(int $categoryId): ?Category
    {
        /** @var Category $category */
        $category = Category::query()
            ->find($categoryId);

        return $category;
    }

    /**
     * @param int $storeId
     * @param string $slug
     * @return Category|null
     */
    public function getCategoryByStoreIdAndSlug(int $storeId, string $slug): ?Category
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('store_id', '=', $storeId)
            ->where('slug', '=', $slug)
            ->first();

        return $category;
    }

    /**
     * @param int $storeId
     * @param string $name
     * @return Category|null
     */
    public function getCategoryByStoreIdAndName(int $storeId, string $name): ?Category
    {
        /** @var Category $category */
        $category = Category::query()
            ->where('store_id', '=', $storeId)
            ->where('name', '=', $name)
            ->first();

        return $category;
    }

    /**
     * @param int $storeId
     * @param array $data
     * @return Category
     */
    public function createCategory(int $storeId, array $data): Category
    {
        $category = new Category();
        $category->fill($data);
        $category->store_id = $storeId;
        $category->save();

        CategoryCreated::dispatch($category);

        return $category;
    }

    /**
     * @param Category $category
     * @param array $data
     * @return void
     */
    public function updateCategory(Category $category, array $data): void
    {
        $category->fill($data);
        $category->save();

        CategoryUpdated::dispatch($category);
    }

    /**
     * @param Category $category
     * @return void
     */
    public function deleteCategory(Category $category): void
    {
        $category->delete();

        CategoryDeleted::dispatch($category);
    }
}
