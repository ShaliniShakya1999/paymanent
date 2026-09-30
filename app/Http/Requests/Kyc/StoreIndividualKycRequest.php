<?php

namespace App\Http\Requests\Kyc;

use App\Rules\PanNumber;
use App\Rules\AadhaarNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreIndividualKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxKb = 2048;
        $maxPhoto = 512;

        return [
            'pan_number' => ['required', 'string', new PanNumber()],
            'pan_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . ($maxKb)],
            'aadhaar_number' => ['required', 'string', new AadhaarNumber()],
            'aadhaar_front' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'aadhaar_back' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'photo' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:' . $maxPhoto],
        ];
    }

    public function attributes(): array
    {
        return [
            'pan_number' => __('PAN Number'),
            'pan_file' => __('PAN Card'),
            'aadhaar_number' => __('Aadhaar Number'),
            'aadhaar_front' => __('Aadhaar Front'),
            'aadhaar_back' => __('Aadhaar Back'),
            'photo' => __('Passport Photo'),
        ];
    }
}
