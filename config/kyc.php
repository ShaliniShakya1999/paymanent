<?php

return [

    /*
    |--------------------------------------------------------------------------
    | KYC Business Types (Entity-wise onboarding — separate UI, steps, checklist)
    |--------------------------------------------------------------------------
    */
    'entities' => [
        'individual' => [
            'label' => 'Individual Merchant',
            'description' => 'For individual / sole proprietor',
            'steps' => [
                ['key' => 'aadhaar', 'title' => 'Aadhaar', 'order' => 1],
                ['key' => 'pan', 'title' => 'PAN Card', 'order' => 2],
                ['key' => 'bank', 'title' => 'Bank Proof', 'order' => 3],
                ['key' => 'business_proof', 'title' => 'Business Proof', 'order' => 4],
                ['key' => 'contact', 'title' => 'Contact Verification', 'order' => 5],
                ['key' => 'selfie_agreement', 'title' => 'Selfie & Agreement', 'order' => 6],
                ['key' => 'review', 'title' => 'Review & Submit', 'order' => 7],
            ],
            'documents' => [
                'aadhaar' => ['label' => 'Aadhaar Card', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048, 'validate_number' => 'aadhaar'],
                'pan' => ['label' => 'PAN Card', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048, 'validate_number' => 'pan'],
                'bank_proof' => ['label' => 'Cancelled Cheque OR Passbook (Name + Account number visible)', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'business_proof' => ['label' => 'Self-declaration OR Utility bill (shop/home address)', 'required' => false, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'selfie' => ['label' => 'Live photo/selfie', 'required' => true, 'accept' => 'image/*', 'max_kb' => 512],
                'merchant_agreement' => ['label' => 'Merchant agreement (e-sign)', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
            ],
        ],

        'proprietorship' => [
            'label' => 'Proprietorship Firm',
            'description' => 'For sole proprietorship business',
            'steps' => [
                ['key' => 'owner_aadhaar', 'title' => 'Owner Aadhaar', 'order' => 1],
                ['key' => 'owner_pan', 'title' => 'Owner PAN', 'order' => 2],
                ['key' => 'business_registration', 'title' => 'Business Registration', 'order' => 3],
                ['key' => 'bank', 'title' => 'Bank Proof', 'order' => 4],
                ['key' => 'address_proof', 'title' => 'Address Proof', 'order' => 5],
                ['key' => 'agreement', 'title' => 'Agreement', 'order' => 6],
                ['key' => 'review', 'title' => 'Review & Submit', 'order' => 7],
            ],
            'business_registration_types' => [
                'shop_establishment' => 'Shop & Establishment Certificate',
                'gst' => 'GST Registration',
                'udyam' => 'Udyam Registration',
                'other' => 'Other',
            ],
            'documents' => [
                'proprietor_aadhaar' => ['label' => 'Proprietor Aadhaar', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048, 'validate_number' => 'aadhaar'],
                'proprietor_pan' => ['label' => 'Proprietor PAN', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048, 'validate_number' => 'pan'],
                'business_registration' => ['label' => 'Business Registration (based on selection)', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'bank_proof' => ['label' => 'Current Account Cancelled Cheque', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'address_proof' => ['label' => 'Business Address Proof', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'agreement' => ['label' => 'Agreement + Declaration (single owner)', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
            ],
        ],

        'partnership' => [
            'label' => 'Partnership Firm',
            'description' => 'For partnership firm',
            'steps' => [
                ['key' => 'firm_pan', 'title' => 'Firm PAN', 'order' => 1],
                ['key' => 'partnership_deed', 'title' => 'Partnership Deed', 'order' => 2],
                ['key' => 'partners', 'title' => 'Add Partners', 'order' => 3],
                ['key' => 'authorization', 'title' => 'Authorization', 'order' => 4],
                ['key' => 'bank', 'title' => 'Bank Proof', 'order' => 5],
                ['key' => 'agreement', 'title' => 'Agreement', 'order' => 6],
                ['key' => 'review', 'title' => 'Review & Submit', 'order' => 7],
            ],
            'documents' => [
                'firm_pan' => ['label' => 'Firm PAN Card', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048, 'validate_number' => 'pan'],
                'partnership_deed' => ['label' => 'Partnership Deed (signed)', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 5120],
                'letter_authorizing_partner' => ['label' => 'Letter authorizing one partner', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'bank_mandate' => ['label' => 'Bank mandate', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'bank_cheque' => ['label' => 'Partnership firm current account cheque', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
                'agreement' => ['label' => 'Agreement signed by authorized partner', 'required' => true, 'accept' => 'image/*,.pdf', 'max_kb' => 2048],
            ],
        ],
    ],

    'max_verification_attempts' => 3,

    'statuses' => [
        'pending' => 'Pending',
        'in_review' => 'Under Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],

    'validation' => [
        'pan' => '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
        'aadhaar' => '/^[0-9]{12}$/',
    ],

];
