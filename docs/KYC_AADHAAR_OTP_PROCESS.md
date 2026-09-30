# KYC Aadhaar OTP Process (PaySprint SprintVerify)

## Overview
Aadhaar verification uses PaySprint SprintVerify API: OTP is sent to the mobile number linked with Aadhaar; user enters OTP to verify.

## Config
- **Config file:** `config/sprintverify.php`
- **Env:** `SPRINTVERIFY_ENABLED`, `SPRINTVERIFY_BASE_URL`, `SPRINTVERIFY_TOKEN`, `SPRINTVERIFY_AUTHORISEDKEY`, `SPRINTVERIFY_USER_AGENT`, `SPRINTVERIFY_TIMEOUT`, `SPRINTVERIFY_VERIFY_SSL`

## Service
- **Class:** `App\Services\AadhaarVerificationService`
- **Methods:**
  - `sendOtp(string $aadhaarNumber)` – Send OTP to Aadhaar-linked mobile
  - `verifyOtp(string $aadhaarNumber, string $otp, ?string $referenceId = null)` – Verify OTP

## Flow
1. User enters 12-digit Aadhaar on KYC step.
2. Backend calls `AadhaarVerificationService::sendOtp($aadhaar)`.
3. User receives OTP on Aadhaar-linked mobile.
4. User enters OTP; backend calls `AadhaarVerificationService::verifyOtp($aadhaar, $otp)`.
5. On success, mark Aadhaar as verified and proceed to next KYC step (e.g. PAN).

## API Base URLs
- **UAT:** `https://uat.paysprint.in/sprintverify-uat`
- **SIT:** Use `https://sit.paysprint.in` and set path in env if SprintVerify SIT path differs.

## Checklist
- [ ] Server can reach PaySprint (firewall/proxy).
- [ ] `.env` has valid `SPRINTVERIFY_TOKEN` and `SPRINTVERIFY_AUTHORISEDKEY`.
- [ ] For local/UAT SSL errors, set `SPRINTVERIFY_VERIFY_SSL=false` if needed.
