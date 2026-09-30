<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;
    
    protected $table   = 'user_details';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'country_id',
        'email_verification',
        'phone_verification_code',
        'two_step_verification_type',
        'two_step_verification_code',
        // 'google2fa_secret',
        'two_step_verification',
        'last_login_at',
        'last_login_ip',
        'city',
        'state',
        'address_1',
        'address_2',
        'default_currency',
        'timezone',
        'merchant_category',
        'kyc_status',
        'kyc_submitted_at',
        'kyc_reviewed_at',
        'kyc_rejection_reason',
        'kyc_submit_count',
        'business_registration_type',
        'kyc_business_registration_number',
        'kyc_business_registration_other_name',
        'kyc_signatory_name',
        'kyc_signatory_phone',
        'kyc_signatory_email',
        'kyc_bank_name',
        'kyc_bank_account_holder_name',
        'kyc_bank_account_number',
        'kyc_bank_ifsc_code',
    ];

    protected $casts = [
        'kyc_submitted_at' => 'datetime',
        'kyc_reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    // protected $hidden = [
    //     'google2fa_secret',
    // ];

    /**
     * Ecrypt the user's google_2fa secret.
     */
    // public function setGoogle2faSecretAttribute($value)
    // {
    //     $this->attributes['google2fa_secret'] = encrypt($value);
    // }

    /**
     * Decrypt the user's google_2fa secret.
     */
    // public function getGoogle2faSecretAttribute($value)
    // {
    //     return decrypt($value);
    // }
    /**
     * Update User detail information when user logged in
     *
     * @param object $user
     * @param string $time
     * @param string $ipAddress
     * @return void
     */
    public function updateUserLoginInfo($user, $time, $ipAddress)
    {
        $user->update([
            'last_login_at' => $time,
            'last_login_ip' => $ipAddress
        ]);
    }
}
