<?php

namespace App\Rules;

use App\Services\ProductService;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ProductSlugUnique implements ValidationRule
{
    private int $storeId;
    private ?int $productId;

    public function __construct(int $storeId, ?int $productId)
    {
        $this->storeId = $storeId;
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @throws BindingResolutionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var ProductService $productService */
        $productService = app()->make(ProductService::class);

        $existingProduct = $productService->getProductByStoreIdAndSlug($this->storeId, $value);
        if ($existingProduct) {
            if ($this->productId && ($existingProduct->id == $this->productId)) {
                return;
            }

            $fail('A product with this slug already exists.');
        }
    }
}
