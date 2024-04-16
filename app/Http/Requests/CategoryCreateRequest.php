<?php

namespace App\Http\Requests;

use App\Http\Helpers\AuthHelper;
use App\Rules\CategoryNameUnique;
use App\Rules\CategorySlugUnique;
use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeId = AuthHelper::getStoreId();

        return [
            'slug' => ['required', 'string', new CategorySlugUnique($storeId, null)],
            'name' => ['required', 'string', new CategoryNameUnique($storeId, null)],
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
