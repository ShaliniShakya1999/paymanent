<?php

/**
 * @package ForgotPasswordService
 * @author tehcvillage <support@techvill.org>
 * @contributor Ashraful Rasel <[ashraful.techvill@gmail.com]>
 * @created 11-1-2023
 */

namespace App\Services;

use App\Exceptions\Api\V2\RegistrationException;
use App\Models\{
    CryptoProvider,
    RoleUser,
    User,
    QrCode,
    VerifyUser,
};
use App\Services\Mail\UserVerificationMailService;
use Exception;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    protected $user;

    /**
     * send forgot password code
     *
     * @param string $email
     * @return void
     */
    public function userRegistration($request)
    {
        try {
            
            $formattedPhone   = str_replace('+' . $request->carrierCode, "", $request->formattedPhone);
            if (!empty($request->phone) && $request->phone !==  $formattedPhone) {
                throw new Exception(__('The phone number provided is incorrect'));
            }

            // Check for duplicate phone using the same cleaning logic as createNewUser
            if (!empty($request->phone)) {
                $cleanedPhone = preg_replace("/[\s-]+/", "", $formattedPhone);
                
                if (User::where('phone', $cleanedPhone)->exists()) {
                    throw new Exception(__('The phone number has already been taken!'));
                }
            }

            DB::beginTransaction();
            $this->user = new User();
            
            try {
                $user = $this->user->createNewUser($request, 'user');
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                // Handle duplicate phone number error
                if ($e->getCode() == 23000 && strpos($e->getMessage(), 'users_phone_unique') !== false) {
                    throw new Exception(__('The phone number has already been taken!'));
                }
                // Re-throw if it's a different error
                throw $e;
            }
            RoleUser::insert(['user_id' => $user->id, 'role_id' => $user->role_id, 'user_type' => 'User']);
            $this->user->createUserDetail($user->id);
            $this->user->createUserDefaultWallet($user->id, settings('default_currency'));
            if ('none' != settings('allowed_wallets')) {
                $this->user->createUserAllowedWallets($user->id, settings('allowed_wallets'));
            }
            QrCode::createUserQrCode($user);
            $userEmail          = $user->email;
            $userFormattedPhone = $user->formattedPhone;
            $this->user->processUnregisteredUserTransfers(
                $userEmail, $userFormattedPhone, $user, settings('default_currency')
            );
            $this->user->processUnregisteredUserRequestPayments(
                $userEmail, $userFormattedPhone, $user, settings('default_currency')
            );
   
            if (isActive('TatumIo') && CryptoProvider::getStatus('TatumIo') == 'Active') {
                $generateUserCryptoWalletAddress = $this->user->generateUserTatumIoWalletAddress($user);
                if ($generateUserCryptoWalletAddress['status'] == 401) {
                    throw new RegistrationException($generateUserCryptoWalletAddress['message']);          
                }
            }

            $this->emailVerification($user);

            DB::commit();

            return [
                'status'  => true,
                'message' => __('Registration Successful.')
            ];

        } catch (Exception $e) {
           DB::rollBack();
           throw new RegistrationException($e->getMessage());
        }

    }

    public function emailVerification($user)
    {
        if ('Enabled' == preference('verification_mail')) {
            if (0 == optional($user->user_detail)->email_verification) {
                (new VerifyUser())->createVerifyUser($user->id);
                (new UserVerificationMailService())->send($user);
            }
        }
    }

}
