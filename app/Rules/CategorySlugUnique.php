<?php

namespace App\Rules;

use App\Services\CategoryService;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CategorySlugUnique implements ValidationRule
{
    private int $storeId;
    private ?int $categoryId;

    public function __construct(int $storeId, ?int $categoryId)
    {
        $this->storeId = $storeId;
        $this->categoryId = $categoryId;
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
        /** @var CategoryService $categoryService */
        $categoryService = app()->make(CategoryService::class);

        $existingCategory = $categoryService->getCategoryByStoreIdAndSlug($this->storeId, $value);
        if ($existingCategory) {
            if ($this->categoryId && ($existingCategory->id == $this->categoryId)) {
                return;
            }

            $fail('A category with this slug already exists.');
        }
    }
}
