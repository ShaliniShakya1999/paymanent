<?php

namespace App\Http\Requests\Kyc;

use App\Rules\PanNumber;
use App\Rules\AadhaarNumber;
use Illuminate\Foundation\Http\FormRequest;

class StorePartnershipKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxKb = 2048;
        $maxDeed = 5120;

        return [
            'pan_number' => ['required', 'string', new PanNumber()],
            'pan_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'aadhaar_number' => ['required', 'string', new AadhaarNumber()],
            'aadhaar_front' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'aadhaar_back' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'partnership_deed' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxDeed],
            'business_proof' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
            'gst_certificate' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:' . $maxKb],
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
            'partnership_deed' => __('Partnership Deed'),
            'business_proof' => __('Business Proof'),
            'gst_certificate' => __('GST Certificate'),
        ];
    }
}
