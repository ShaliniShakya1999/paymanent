<?php

namespace App\Http\Requests\Kyc;

use Illuminate\Foundation\Http\FormRequest;

class StoreKycCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'merchant_category' => ['required', 'string', 'in:individual,proprietorship,partnership'],
        ];
    }

    public function attributes(): array
    {
        return [
            'merchant_category' => __('Merchant Category'),
        ];
    }
}
