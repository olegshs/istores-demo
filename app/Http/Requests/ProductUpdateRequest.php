<?php

namespace App\Http\Requests;

use App\Http\Helpers\AuthHelper;
use App\Rules\ProductNameUnique;
use App\Rules\ProductSlugUnique;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeId = AuthHelper::getStoreId();
        $productId = $this->route('product')?->id;

        return [
            'slug' => ['string', new ProductSlugUnique($storeId, $productId)],
            'name' => ['string', new ProductNameUnique($storeId, $productId)],
            'price' => ['decimal:0,2'],
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
