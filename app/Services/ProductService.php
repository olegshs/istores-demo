<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Models\Category;
use App\Models\Product;
use App\Services\Traits\PagingTrait;
use App\Services\Traits\SortingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    use SortingTrait;
    use PagingTrait;

    /**
     * @param int $storeId
     * @param array|null $categoryIds
     * @return int
     */
    public function getProductCountByStoreId(int $storeId, array $categoryIds = null): int
    {
        $query = Product::query()
            ->where('store_id', '=', $storeId);

        if ($categoryIds) {
            $query->whereHas('categories', function (Builder $query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        return $query->count();
    }

    /**
     * @param int $storeId
     * @param array|null $categoryIds
     * @param array $withRelations
     * @return Collection|array
     */
    public function getProductListByStoreId(int $storeId, array $categoryIds = null, array $withRelations = []): Collection|array
    {
        $query = Product::query()
            ->with($withRelations)
            ->where('store_id', '=', $storeId);

        if ($categoryIds) {
            $query->whereHas('categories', function (Builder $query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        $this->addSorting($query);
        $this->addPaging($query);

        return $query->get();
    }

    /**
     * @param int $productId
     * @param array $withRelations
     * @return Product|null
     */
    public function getProductById(int $productId, array $withRelations = []): ?Product
    {
        /** @var Product $product */
        $product = Product::query()
            ->with($withRelations)
            ->find($productId);

        return $product;
    }

    /**
     * @param int $storeId
     * @param string $slug
     * @return Product|null
     */
    public function getProductByStoreIdAndSlug(int $storeId, string $slug): ?Product
    {
        /** @var Product $product */
        $product = Product::query()
            ->where('store_id', '=', $storeId)
            ->where('slug', '=', $slug)
            ->first();

        return $product;
    }

    /**
     * @param int $storeId
     * @param string $name
     * @return Product|null
     */
    public function getProductByStoreIdAndName(int $storeId, string $name): ?Product
    {
        /** @var Product $product */
        $product = Product::query()
            ->where('store_id', '=', $storeId)
            ->where('name', '=', $name)
            ->first();

        return $product;
    }

    /**
     * @param int $storeId
     * @param array $data
     * @return Product
     */
    public function createProduct(int $storeId, array $data): Product
    {
        $product = new Product();
        $product->fill($data);
        $product->store_id = $storeId;
        $product->save();

        ProductCreated::dispatch($product);

        return $product;
    }

    /**
     * @param Product $product
     * @param array $data
     * @return void
     */
    public function updateProduct(Product $product, array $data): void
    {
        $product->fill($data);
        $product->save();

        ProductUpdated::dispatch($product);
    }

    /**
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product): void
    {
        $product->delete();

        ProductDeleted::dispatch($product);
    }

    /**
     * @param Product $product
     * @return Collection|Category[]
     */
    public function getProductCategories(Product $product): Collection|array
    {
        return $product->categories()
            ->orderBy('name')
            ->get();
    }

    /**
     * @param Product $product
     * @param array $categoryIds
     * @return void
     */
    public function addProductCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->attach($categoryIds);
    }

    /**
     * @param Product $product
     * @param array $categoryIds
     * @return void
     */
    public function replaceProductCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->sync($categoryIds);
    }

    /**
     * @param Product $product
     * @param array $categoryIds
     * @return void
     */
    public function deleteProductCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->detach($categoryIds);
    }
}
