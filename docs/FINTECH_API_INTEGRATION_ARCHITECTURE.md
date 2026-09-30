# FinTech API Integration – Architecture & Implementation Guide

**Platform:** Laravel | **Frontend:** Blade + AJAX | **Auth:** Token-based API

---

## 1. Overall System Architecture

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           USER PANEL (Blade + AJAX)                       │
│  AEPS │ Bus Booking │ Recharge │ BBPS Bill Payment │ Verification (KYC)  │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
┌───────────────────────────────────▼─────────────────────────────────────┐
│                     Laravel Controllers (Web + API)                       │
│  RechargeController │ BillPaymentController │ BusController │ etc.        │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
┌───────────────────────────────────▼─────────────────────────────────────┐
│                    Service Layer (App\Services\)                          │
│  RechargeApiService │ BillPaymentApiService │ AadhaarVerificationService  │
│  GstVerificationService │ PanVerificationService │ BusBookingApiService   │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
┌───────────────────────────────────▼─────────────────────────────────────┐
│         HTTP Client (Laravel Http) │ cURL │ Retry │ Timeout               │
└───────────────────────────────────┬─────────────────────────────────────┘
                                    │
┌───────────────────────────────────▼─────────────────────────────────────┐
│              Third-Party APIs (PaySprint / Partner Gateways)              │
└─────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────┐
│  DB: recharge_transactions │ bill_payment_transactions │ bus_bookings     │
│  api_request_logs │ verification_logs │ Transaction (main)               │
└─────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────┐
│                    ADMIN PANEL                                            │
│  Service toggles │ Transaction lists │ Reports │ Refund/Cancel │ Logs    │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Recommended Laravel Folder Structure

```
app/
├── Config/
│   ├── recharge.php
│   ├── bill_payment.php
│   ├── bus_booking.php
│   ├── verification.php      # PAN, GST, MCA, Aadhaar OTP
│   └── aeps.php
├── Services/
│   ├── BaseApiService.php    # Shared: headers, timeout, retry, log
│   ├── RechargeApiService.php
│   ├── BillPaymentApiService.php
│   ├── BusBookingApiService.php
│   ├── AadhaarVerificationService.php
│   ├── GstVerificationService.php
│   ├── PanVerificationService.php
│   └── McaVerificationService.php
├── Http/Controllers/
│   ├── Users/
│   │   ├── RechargeController.php
│   │   ├── BillPaymentController.php
│   │   ├── BusController.php
│   │   ├── AepsController.php
│   │   └── VerificationController.php   # PAN, GST, Aadhaar OTP
│   └── Admin/
│       ├── RechargeTransactionController.php
│       ├── BillPaymentTransactionController.php
│       ├── BusBookingController.php
│       └── VerificationLogController.php
├── Models/
│   ├── RechargeTransaction.php
│   ├── BillPaymentTransaction.php
│   ├── BusBooking.php
│   ├── ApiRequestLog.php
│   └── VerificationLog.php
├── Rules/
│   ├── AadhaarNumber.php
│   ├── PanNumber.php
│   └── GstinNumber.php
└── Traits/
    └── GeneratesReferenceId.php

database/migrations/
├── recharge_transactions
├── bill_payment_transactions
├── bus_bookings
├── api_request_logs
└── verification_logs
```

---

## 3. Module-Wise Specification

### 3.1 AEPS (Aadhaar Enabled Payment System)

| Item | Detail |
|------|--------|
| **Purpose** | Agent/user registration with AEPS provider; authenticate and perform Aadhaar-linked transactions. |
| **User flow** | 1) Navigate to AEPS → 2) Registration (if first time) with provider credentials → 3) Authenticate (Aadhaar + biometric/OTP) → 4) Perform cash-in/cash-out (UI already there). |
| **Admin** | View AEPS registrations, success/fail counts, toggle AEPS on/off, view transaction list and logs. |
| **API endpoints** | `POST /registration`, `POST /authenticate` (partner-specific paths). |
| **Service** | `App\Services\AepsApiService` → `register()`, `authenticate()`. |
| **Controller** | `AepsController@register`, `AepsController@authenticate`. |
| **DB** | `aeps_registrations` (user_id, provider_ref, status), `aeps_transactions` (user_id, reference_id, amount, type, status, api_request, api_response). |
| **Logging** | Log every API request/response in `api_request_logs`; store transaction in `aeps_transactions`. |
| **Status** | pending, success, failed. |
| **Security** | Store provider tokens encrypted; never log full Aadhaar; use HTTPS only. |

---

### 3.2 Bus Booking

| Item | Detail |
|------|--------|
| **Purpose** | Search trips, block seat, book ticket, cancel ticket. |
| **User flow** | 1) Select source city (Get Source City) → 2) Get Available Trips → 3) Select trip → 4) Get Boarding Point Detail → 5) Block Ticket → 6) Book Ticket → 7) Optional: Check Booked Ticket / Get Booked Ticket / Get Cancellation Data / Ticket Cancellation. |
| **Admin** | List all bookings, filter by date/status, cancel/refund from admin, reports (bookings per day, cancellation rate). |
| **API endpoints** | Get Source City, Get Available Trips, Get Current Trip Details, Get Boarding Point Detail, Block Ticket, Book Ticket, Check Booked Ticket, Get Booked Ticket, Get Cancellation Data, Ticket Cancellation. |
| **Service** | `BusBookingApiService` → `getSourceCities()`, `getAvailableTrips()`, `getTripDetails()`, `getBoardingPoints()`, `blockTicket()`, `bookTicket()`, `checkBookedTicket()`, `getBookedTicket()`, `getCancellationData()`, `cancelTicket()`. |
| **Controller** | `BusController@getSourceCities`, `getTrips`, `blockTicket`, `bookTicket`, `getBookedTicket`, `cancelTicket`, etc. |
| **DB** | `bus_bookings` (user_id, reference_id, trip_id, pnr, amount, status, passenger_details, api_request, api_response, booked_at). |
| **Logging** | Log each API call; store booking in `bus_bookings` on book/cancel. |
| **Status** | blocked, booked, cancelled, failed. |
| **Duplicate** | Use unique `reference_id` per book/cancel; idempotency key if partner supports. |

---

### 3.3 Recharge

| Item | Detail |
|------|--------|
| **Purpose** | Mobile/DTH recharge via operator list, do recharge, status enquiry. |
| **User flow** | 1) Page load → Get Operator List → 2) User selects operator, mobile, amount → 3) Do Recharge → 4) Show loading → 5) If pending, Status Enquiry (poll or backend) → 6) Show success/fail toast; store in Transactions. |
| **Admin** | List recharge_transactions, filter by status/date/user, toggle Recharge service on/off. |
| **API endpoints** | Operator List (POST), Do Recharge (POST), Status (POST). |
| **Service** | `RechargeApiService` → `getOperators()`, `doRecharge()`, `getStatus()`. |
| **Controller** | `RechargeController@getOperators`, `doRecharge`. |
| **DB** | `recharge_transactions` (user_id, operator_id, mobile, amount, reference_id, status, api_request, api_response). |
| **Logging** | Log in api_request_logs; transaction in recharge_transactions. |
| **Status** | pending, success, failed, api_failed. |

---

### 3.4 BBPS Bill Payment

| Item | Detail |
|------|--------|
| **Purpose** | Fetch bill by operator + consumer number, pay bill, check status. |
| **User flow** | 1) Get Operator List → 2) Enter consumer number, select operator → 3) Fetch Bill Details → 4) Show summary → 5) Pay Bill → 6) Status Enquiry if pending → 7) Success/fail; store in Transactions. |
| **Admin** | List bill_payment_transactions, filter, toggle service, reports. |
| **API endpoints** | Operator List, Fetch Bill, Pay Bill, Status. |
| **Service** | `BillPaymentApiService` → `getOperators()`, `fetchBill()`, `payBill()`, `getStatus()`. |
| **Controller** | `BillPaymentController@getOperators`, `fetchBill`, `payBill`, `getStatus`. |
| **DB** | `bill_payment_transactions` (user_id, operator_id, canumber, amount, reference_id, status, bill_fetch, api_request, api_response). |
| **Status** | pending, success, failed, api_failed. |

---

### 3.5 Verification Services (KYC)

| Item | Detail |
|------|--------|
| **Purpose** | OCR PAN, PAN Detailed, MCA, GST, Aadhaar Send OTP, Aadhaar Verify OTP for KYC/onboarding. |
| **User flow** | 1) User on KYC/Verification page → 2) Choose type (PAN/GST/Aadhaar/etc.) → 3) Submit document/number → 4) Backend calls verification API → 5) Show result (verified/failed). For Aadhaar: Send OTP → user enters OTP → Verify OTP. |
| **Admin** | View verification_logs, success/fail counts, resend/retry controls if any. |
| **API endpoints** | OCR PAN Verify, PAN Detailed Verify, MCA Verify, GST Verify, Aadhaar Send OTP, Aadhaar Verify OTP. |
| **Service** | `PanVerificationService`, `GstVerificationService`, `McaVerificationService`, `AadhaarVerificationService`. |
| **Controller** | `VerificationController` or KYC module → methods per verification type. |
| **DB** | `verification_logs` (user_id, type: pan_ocr/pan_detail/mca/gst/aadhaar_otp, request_ref, status, api_request, api_response). |
| **Status** | pending, verified, failed. |

---

## 4. Service Layer Design (API Integration)

- **One service per partner/domain:** e.g. `RechargeApiService`, `BillPaymentApiService`.
- **Config-driven:** Base URL, token, timeout, paths in `config/*.php` and `.env`.
- **Shared behaviour:** Extend or use `BaseApiService` (or trait) for:
  - Default headers (Authorisedkey, Token, content-type).
  - Timeout and SSL verify.
  - Retry (e.g. 2 retries with 1–2s delay for GET/status).
  - Optional: log every request/response via `ApiRequestLog`.
- **Return shape:** Every method returns `['success' => bool, 'message' => ?, 'data' => ?, 'status' => ?]` so controllers and UI can handle uniformly.

---

## 5. API Request/Response Logging

- **Table:** `api_request_logs` (module, endpoint, request_headers_mask, request_body, response_status, response_body, reference_id, user_id, created_at).
- **Mask:** Never log full Aadhaar/PAN/token; mask in request_headers and request_body before save.
- **Service:** `ApiRequestLogService::log($module, $endpoint, $request, $response, $referenceId)`.
- **Use:** Call from each service after HTTP call (or in BaseApiService).

---

## 6. Transaction Reference ID Strategy

- **Format:** `{PREFIX}{RANDOM}{TIMESTAMP}` e.g. `RCH` + 8 alphanumeric + time(), `BIL` for bill, `BUS` for bus, `AEPS` for AEPS, `VER` for verification.
- **Uniqueness:** Ensure unique in DB (unique index on reference_id); regenerate if collision (rare).
- **Trait:** `GeneratesReferenceId::generate(string $prefix): string` used by controllers/services.

---

## 7. Timeout and Retry Strategy

- **Timeout:** Default 30s in config; override per module (e.g. 15s for status, 45s for book).
- **Retry:** Only for idempotent or status-check calls (e.g. getStatus, getBookedTicket). Max 2–3 retries, 1–2s delay. No retry for payment/booking submit to avoid double debit.

---

## 8. Error Handling and Duplicate Transactions

- **Errors:** Catch `Exception` in services; return `['success' => false, 'message' => $e->getMessage()]`; log in Laravel Log and optionally in api_request_logs.
- **Duplicate:** Use unique `reference_id` for every financial action; store in DB. Before calling partner “book/pay”, check if reference_id already exists and return stored result if found.

---

## 9. Status Tracking (All Modules)

- **Standard statuses:** `pending`, `success`, `failed`, `refunded`/`cancelled` where applicable.
- **Store in:** Module table (e.g. recharge_transactions.status) and optionally sync to main `transactions` with a type like “Recharge”/“Bill Payment”/“Bus” and note.

---

## 10. Security for Financial APIs

- Store API keys/tokens in `.env`; never in code.
- Use HTTPS only; verify SSL in production (disable only for local/UAT if needed).
- Mask sensitive data in logs and admin views (Aadhaar, PAN, card numbers).
- Rate limit per user for expensive/verification APIs.
- CSRF for all web forms; validate input (Aadhaar 12 digit, PAN format, GSTIN format).

---

## 11. Admin Dashboard – Monitoring and Reports

- **Service toggles:** Config or DB flags to enable/disable each module (Recharge, BBPS, Bus, AEPS, Verification) without code change.
- **Transaction lists:** Per-module (Recharge, Bill Payment, Bus, AEPS) with filters: date range, status, user.
- **Reports:** Count by status (success/failed/pending), volume by day, top users; export CSV.
- **Logs:** List api_request_logs filtered by module/date/reference_id for debugging.

---

## 12. Production Readiness Checklist

- [ ] All API keys in .env; no hardcoding.
- [ ] HTTPS and SSL verification on.
- [ ] Migrations run (recharge_transactions, bill_payment_transactions, bus_bookings, api_request_logs, verification_logs).
- [ ] Reference ID unique and logged.
- [ ] Error handling and user-facing messages; no stack trace to user.
- [ ] Admin can disable each financial service.
- [ ] Request/response logging (masked) for audit.
- [ ] Timeout and retry configured per API.
- [ ] Duplicate transaction check by reference_id before calling partner.

---

## 13. Suggested UI Components (Already Developed – Integration Points)

- **Recharge:** Operator dropdown (from API), mobile input, amount, Recharge button, loader, toast.
- **BBPS:** Operator dropdown, consumer number, Fetch Bill button, bill summary, Pay Now, success screen with reference_id.
- **Bus:** Source city dropdown, trip list, seat selection, boarding point, Block/Book, PNR display, Cancel ticket.
- **Verification:** PAN/GST/Aadhaar input, Send OTP / Verify OTP buttons, result message.
- **AEPS:** Registration form, Authenticate button, result/transaction status.

---

## 14. Role of Admin

- Enable/disable each service (Recharge, BBPS, Bus, AEPS, Verification).
- View and filter all transactions per module.
- Resolve disputes (refund/cancel where applicable).
- View API logs for failed transactions.
- Export reports (daily volume, success rate, revenue if applicable).

---

*This document is the single source of truth for FinTech API integration on the platform. Implement services, controllers, and DB per module as per this architecture.*
