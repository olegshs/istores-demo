<?php

namespace App\Http\Requests;

use App\Http\Helpers\AuthHelper;
use App\Rules\CategoryNameUnique;
use App\Rules\CategorySlugUnique;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeId = AuthHelper::getStoreId();
        $categoryId = $this->route('category')?->id;

        return [
            'slug' => ['string', new CategorySlugUnique($storeId, $categoryId)],
            'name' => ['string', new CategoryNameUnique($storeId, $categoryId)],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('slug')) {
            $this->merge([
                'slug' => mb_strtolower($this->input('slug')),
            ]);
        }
    }
}
