<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Http\Requests\Kyc\StoreKycCategoryRequest;
use App\Models\DocumentVerification;
use App\Models\File;
use App\Models\KycPartner;
use App\Models\UserDetail;
use App\Services\KycChecklistService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Rules\PanNumber;
use App\Rules\AadhaarNumber;
use Illuminate\Support\Facades\Session;

class KycOnboardingController extends Controller
{
    protected $helper;
    protected $kycChecklist;

    public function __construct(Common $helper, KycChecklistService $kycChecklist)
    {
        $this->helper = $helper;
        $this->kycChecklist = $kycChecklist;
    }

    public function category(Request $request)
    {
        $detail = $request->user()->user_detail;
        if ($detail && $detail->merchant_category && $detail->kyc_status === 'approved') {
            return redirect()->route('user.dashboard');
        }
        if ($detail && $detail->merchant_category && $detail->kyc_status === 'in_review') {
            return redirect()->route('user.kyc.under-review');
        }
        if ($detail && $detail->merchant_category && in_array($detail->kyc_status, ['pending', 'rejected'])) {
            return redirect()->route("user.kyc.{$detail->merchant_category}.step", ['step' => 1]);
        }

        $data['entities'] = config('kyc.entities', []);
        return view('user.kyc.category', $data);
    }

    public function storeCategory(StoreKycCategoryRequest $request)
    {
        $category = $request->validated()['merchant_category'];
        $detail = $request->user()->user_detail;

        if (!$detail) {
            $this->helper->one_time_message('error', __('User details not found.'));
            return redirect()->route('user.kyc.category');
        }

        $detail->merchant_category = $category;
        $detail->kyc_status = 'pending';
        $detail->kyc_rejection_reason = null;
        $detail->business_registration_type = null;
        $detail->save();

        $this->helper->one_time_message('success', __('Business type saved. Complete the steps below.'));
        return redirect()->route("user.kyc.{$category}.step", ['step' => 1]);
    }

    /**
     * Show step N (1-6) for entity. Step 7 = review is separate route.
     */
    public function showStep(Request $request, int $step)
    {
        $entity = $this->entityFromRoute($request);
        $user = $request->user();
        $detail = $user->user_detail;
        if (!$this->ensureEntity($detail, $entity)) {
            return redirect()->route('user.kyc.category');
        }
        if ($detail->kyc_status === 'in_review') {
            return redirect()->route('user.kyc.under-review');
        }
        if ($detail->kyc_status === 'approved') {
            return redirect()->route('user.dashboard');
        }

        $steps = $this->kycChecklist->getSteps($entity);
        $contentSteps = array_filter($steps, fn ($s) => ($s['key'] ?? '') !== 'review');
        $contentSteps = array_values($contentSteps);
        if ($step < 1 || $step > count($contentSteps)) {
            return redirect()->route("user.kyc.{$entity}.step", ['step' => 1]);
        }

        $currentStepConfig = $contentSteps[$step - 1] ?? null;
        $stepKey = $currentStepConfig['key'] ?? ('step' . $step);

        $data = [
            'entity' => $entity,
            'step' => $step,
            'stepKey' => $stepKey,
            'steps' => $steps,
            'totalContentSteps' => count($contentSteps),
            'uploaded' => $this->kycChecklist->getUploadedDocuments($user->id),
            'progress' => $this->kycChecklist->getProgress($user->id, $entity),
            'checklist' => $this->kycChecklist->getChecklistForEntity($entity),
            'detail' => $detail,
            'sprintverify_enabled' => (bool) config('sprintverify.enabled', false),
        ];
        if ($entity === 'proprietorship') {
            $data['business_registration_types'] = config('kyc.entities.proprietorship.business_registration_types', []);
            $data['business_registration_type'] = $detail->business_registration_type;
        }
        if ($entity === 'partnership') {
            $data['partners'] = KycPartner::where('user_id', $user->id)->orderBy('sort_order')->get();
        }

        $view = "user.kyc.{$entity}.step-{$step}";
        if (!view()->exists($view)) {
            $view = "user.kyc.{$entity}.step";
            $data['stepView'] = "user.kyc.{$entity}.steps.step-{$step}";
        }
        return view($view, $data);
    }

    /**
     * Store step N data and redirect to next step or review.
     */
    public function storeStep(Request $request, int $step)
    {
        $entity = $this->entityFromRoute($request);
        $user = $request->user();
        $detail = $user->user_detail;
        if (!$this->ensureEntity($detail, $entity)) {
            return redirect()->route('user.kyc.category');
        }

        $steps = $this->kycChecklist->getSteps($entity);
        $contentSteps = array_values(array_filter($steps, fn ($s) => ($s['key'] ?? '') !== 'review'));
        if ($step < 1 || $step > count($contentSteps)) {
            return redirect()->route("user.kyc.{$entity}.step", ['step' => 1]);
        }

        $method = 'store' . ucfirst($entity) . 'Step' . $step;
        if (!method_exists($this, $method)) {
            $this->helper->one_time_message('error', __('Invalid step.'));
            return redirect()->route("user.kyc.{$entity}.step", ['step' => $step])->withInput();
        }

        $result = $this->$method($request, $user, $detail);
        if ($result !== true) {
            return $result; // redirect with error
        }

        $nextStep = $step + 1;
        if ($nextStep > count($contentSteps)) {
            return redirect()->route("user.kyc.{$entity}.review");
        }
        $this->helper->one_time_message('success', __('Saved. Continue to next step.'));
        return redirect()->route("user.kyc.{$entity}.step", ['step' => $nextStep]);
    }

    /**
     * Review & Submit: show checklist; submit disabled if missing docs.
     */
    public function showReview(Request $request)
    {
        $entity = $this->entityFromRoute($request);
        $user = $request->user();
        $detail = $user->user_detail;
        if (!$this->ensureEntity($detail, $entity)) {
            return redirect()->route('user.kyc.category');
        }
        if ($detail->kyc_status === 'in_review') {
            return redirect()->route('user.kyc.under-review');
        }
        if ($detail->kyc_status === 'approved') {
            return redirect()->route('user.dashboard');
        }

        $maxAttempts = (int) config('kyc.max_verification_attempts', 3);
        $submitCount = (int) ($detail->kyc_submit_count ?? 0);
        $remainingAttempts = max(0, $maxAttempts - $submitCount);
        $hasAllDocs = $this->kycChecklist->hasAllRequiredDocuments($user->id, $entity);

        $data = [
            'entity' => $entity,
            'steps' => $this->kycChecklist->getSteps($entity),
            'uploaded' => $this->kycChecklist->getUploadedDocuments($user->id),
            'progress' => $this->kycChecklist->getProgress($user->id, $entity),
            'checklist' => $this->kycChecklist->getChecklistForEntity($entity),
            'canSubmit' => $hasAllDocs && $remainingAttempts > 0,
            'remainingAttempts' => $remainingAttempts,
            'maxAttempts' => $maxAttempts,
            'currentStep' => 'review',
        ];
        if ($entity === 'partnership') {
            $data['partners'] = KycPartner::where('user_id', $user->id)->orderBy('sort_order')->get();
        }
        return view("user.kyc.{$entity}.review", $data);
    }

    /**
     * Final submit: validate all required, set in_review.
     */
    public function submitReview(Request $request)
    {
        $entity = $this->entityFromRoute($request);
        $user = $request->user();
        $detail = $user->user_detail;
        if (!$this->ensureEntity($detail, $entity)) {
            return redirect()->route('user.kyc.category');
        }
        if (!$this->kycChecklist->hasAllRequiredDocuments($user->id, $entity)) {
            $this->helper->one_time_message('error', __('Please upload all required documents before submitting.'));
            return redirect()->route("user.kyc.{$entity}.review");
        }

        $maxAttempts = (int) config('kyc.max_verification_attempts', 3);
        $currentCount = (int) ($detail->kyc_submit_count ?? 0);
        if ($currentCount >= $maxAttempts) {
            $this->helper->one_time_message('error', __('You have used all :max verification attempts. Please contact support.', ['max' => $maxAttempts]));
            return redirect()->route('user.kyc.rejected');
        }

        $detail->kyc_status = 'in_review';
        $detail->kyc_submitted_at = now();
        $detail->kyc_rejection_reason = null;
        $detail->kyc_submit_count = $currentCount + 1;
        $detail->save();

        $this->helper->one_time_message('success', __('Your KYC has been submitted and is under verification.'));
        return redirect()->route('user.kyc.under-review');
    }

    public function underReview(Request $request)
    {
        $detail = $request->user()->user_detail;
        if (!$detail || $detail->kyc_status !== 'in_review') {
            if ($detail && $detail->kyc_status === 'approved') {
                return redirect()->route('user.dashboard');
            }
            if ($detail && $detail->merchant_category) {
                return redirect()->route("user.kyc.{$detail->merchant_category}.step", ['step' => 1]);
            }
            return redirect()->route('user.kyc.category');
        }
        return view('user.kyc.under-review');
    }

    public function rejected(Request $request)
    {
        $detail = $request->user()->user_detail;
        if (!$detail || $detail->kyc_status !== 'rejected') {
            if ($detail && $detail->kyc_status === 'approved') {
                return redirect()->route('user.dashboard');
            }
            if ($detail && $detail->kyc_status === 'in_review') {
                return redirect()->route('user.kyc.under-review');
            }
            if ($detail && $detail->merchant_category) {
                return redirect()->route("user.kyc.{$detail->merchant_category}.step", ['step' => 1]);
            }
            return redirect()->route('user.kyc.category');
        }
        $maxAttempts = (int) config('kyc.max_verification_attempts', 3);
        $submitCount = (int) ($detail->kyc_submit_count ?? 0);
        $remainingAttempts = max(0, $maxAttempts - $submitCount);

        $data['rejection_reason'] = $detail->kyc_rejection_reason;
        $data['entity'] = $detail->merchant_category;
        $data['remaining_attempts'] = $remainingAttempts;
        $data['max_attempts'] = $maxAttempts;
        $data['can_resubmit'] = $remainingAttempts > 0;
        return view('user.kyc.rejected', $data);
    }

    protected function entityFromRoute(Request $request): string
    {
        $name = $request->route()?->getName() ?? '';
        if (str_contains($name, 'individual')) {
            return 'individual';
        }
        if (str_contains($name, 'proprietorship')) {
            return 'proprietorship';
        }
        if (str_contains($name, 'partnership')) {
            return 'partnership';
        }
        return 'individual';
    }

    protected function ensureEntity($detail, string $entity): bool
    {
        return $detail && $detail->merchant_category === $entity;
    }

    protected function saveDocument(int $userId, string $documentType, $file, ?string $identityNumber = null): void
    {
        $path = 'uploads/kyc-documents';
        $uploadPath = public_path($path);
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $ext = strtolower($file->getClientOriginalExtension());
        $originalName = $file->getClientOriginalName();
        $uniqueName = $userId . '_' . $documentType . '_' . time() . '.' . $ext;
        $file->move($uploadPath, $uniqueName);

        $fileModel = new File();
        $fileModel->user_id = $userId;
        $fileModel->filename = $uniqueName;
        $fileModel->originalname = $originalName;
        $fileModel->type = $ext;
        $fileModel->save();

        DocumentVerification::updateOrCreate(
            ['user_id' => $userId, 'document_type' => $documentType],
            [
                'file_id' => $fileModel->id,
                'verification_type' => 'identity',
                'identity_type' => $documentType,
                'identity_number' => $identityNumber,
                'status' => 'pending',
            ]
        );
    }

    // ---------- Individual: store step 1-6 ----------
    protected function storeIndividualStep1(Request $request, $user, $detail)
    {
        if (config('sprintverify.enabled', false)) {
            $verifiedNumber = Session::get('kyc_aadhaar_verified_number');
            if ($verifiedNumber !== $request->input('aadhaar_number')) {
                $this->helper->one_time_message('error', __('Please verify your Aadhaar with OTP before continuing.'));
                return redirect()->route('user.kyc.individual.step', ['step' => 1])->withInput();
            }
        }

        $v = Validator::make($request->all(), [
            'aadhaar_number' => ['required', 'string', new AadhaarNumber()],
            'aadhaar_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['aadhaar_number' => __('Aadhaar Number'), 'aadhaar_file' => __('Aadhaar Card')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.individual.step', ['step' => 1])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'aadhaar', $request->file('aadhaar_file'), $request->aadhaar_number);
        Session::forget('kyc_aadhaar_verified_number');
        return true;
    }

    protected function storeIndividualStep2(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'pan_number' => ['required', 'string', new PanNumber()],
            'pan_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['pan_number' => __('PAN Number'), 'pan_file' => __('PAN Card')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.individual.step', ['step' => 2])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'pan', $request->file('pan_file'), strtoupper(preg_replace('/\s+/', '', $request->pan_number)));
        return true;
    }

    protected function storeIndividualStep3(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'kyc_bank_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_holder_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_number' => ['required', 'string', 'max:50'],
            'kyc_bank_ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'bank_proof' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], [
            'kyc_bank_name' => __('Bank name'),
            'kyc_bank_account_holder_name' => __('Account holder name'),
            'kyc_bank_account_number' => __('Account number'),
            'kyc_bank_ifsc_code' => __('IFSC code'),
            'bank_proof' => __('Bank Proof'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.individual.step', ['step' => 3])->withInput()->withErrors($v);
        }
        $detail->kyc_bank_name = $request->kyc_bank_name;
        $detail->kyc_bank_account_holder_name = $request->kyc_bank_account_holder_name;
        $detail->kyc_bank_account_number = $request->kyc_bank_account_number;
        $detail->kyc_bank_ifsc_code = strtoupper($request->kyc_bank_ifsc_code);
        $detail->save();
        $this->saveDocument($user->id, 'bank_proof', $request->file('bank_proof'));
        return true;
    }

    protected function storeIndividualStep4(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'business_proof' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['business_proof' => __('Business Proof')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.individual.step', ['step' => 4])->withInput()->withErrors($v);
        }
        if ($request->hasFile('business_proof')) {
            $this->saveDocument($user->id, 'business_proof', $request->file('business_proof'));
        }
        return true;
    }

    protected function storeIndividualStep5(Request $request, $user, $detail)
    {
        // Contact: mobile/email usually already on user; we can just mark as verified or skip file. Use a placeholder doc or skip.
        return true;
    }

    protected function storeIndividualStep6(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'selfie' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:512'],
            'merchant_agreement' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['selfie' => __('Selfie'), 'merchant_agreement' => __('Merchant Agreement')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.individual.step', ['step' => 6])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'selfie', $request->file('selfie'));
        $this->saveDocument($user->id, 'merchant_agreement', $request->file('merchant_agreement'));
        return true;
    }

    // ---------- Proprietorship: store step 1-6 ----------
    protected function storeProprietorshipStep1(Request $request, $user, $detail)
    {
        if (config('sprintverify.enabled', false)) {
            $verifiedNumber = Session::get('kyc_aadhaar_verified_number');
            if ($verifiedNumber !== $request->input('aadhaar_number')) {
                $this->helper->one_time_message('error', __('Please verify your Aadhaar with OTP before continuing.'));
                return redirect()->route('user.kyc.proprietorship.step', ['step' => 1])->withInput();
            }
        }

        $v = Validator::make($request->all(), [
            'aadhaar_number' => ['required', 'string', new AadhaarNumber()],
            'aadhaar_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['aadhaar_number' => __('Aadhaar Number'), 'aadhaar_file' => __('Aadhaar Card')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 1])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'proprietor_aadhaar', $request->file('aadhaar_file'), $request->aadhaar_number);
        Session::forget('kyc_aadhaar_verified_number');
        return true;
    }

    protected function storeProprietorshipStep2(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'pan_number' => ['required', 'string', new PanNumber()],
            'pan_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['pan_number' => __('PAN Number'), 'pan_file' => __('PAN Card')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 2])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'proprietor_pan', $request->file('pan_file'), strtoupper(preg_replace('/\s+/', '', $request->pan_number)));
        return true;
    }

    protected function storeProprietorshipStep3(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'business_registration_type' => ['required', 'string', 'in:shop_establishment,gst,udyam,other'],
            'kyc_business_registration_number' => ['required', 'string', 'max:100'],
            'kyc_business_registration_other_name' => ['required_if:business_registration_type,other', 'nullable', 'string', 'max:191'],
            'business_registration' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'kyc_signatory_name' => ['required', 'string', 'max:191'],
            'kyc_signatory_phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'kyc_signatory_email' => ['required', 'email', 'max:191'],
        ], [], [
            'business_registration_type' => __('Registration Type'),
            'kyc_business_registration_number' => __('Registration / GST / License number'),
            'kyc_business_registration_other_name' => __('Document name'),
            'business_registration' => __('Document'),
            'kyc_signatory_name' => __('Authorised Signatory name'),
            'kyc_signatory_phone' => __('Authorised Signatory mobile'),
            'kyc_signatory_email' => __('Authorised Signatory email'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 3])->withInput()->withErrors($v);
        }
        $detail->business_registration_type = $request->business_registration_type;
        $detail->kyc_business_registration_number = $request->kyc_business_registration_number;
        $detail->kyc_business_registration_other_name = $request->business_registration_type === 'other'
            ? $request->kyc_business_registration_other_name
            : null;
        $detail->kyc_signatory_name = $request->kyc_signatory_name;
        $detail->kyc_signatory_phone = $request->kyc_signatory_phone;
        $detail->kyc_signatory_email = $request->kyc_signatory_email;
        $detail->save();
        $this->saveDocument($user->id, 'business_registration', $request->file('business_registration'));
        return true;
    }

    protected function storeProprietorshipStep4(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'kyc_bank_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_holder_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_number' => ['required', 'string', 'max:50'],
            'kyc_bank_ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'bank_proof' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], [
            'kyc_bank_name' => __('Bank name'),
            'kyc_bank_account_holder_name' => __('Account holder name'),
            'kyc_bank_account_number' => __('Account number'),
            'kyc_bank_ifsc_code' => __('IFSC code'),
            'bank_proof' => __('Bank Proof'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 4])->withInput()->withErrors($v);
        }
        $detail->kyc_bank_name = $request->kyc_bank_name;
        $detail->kyc_bank_account_holder_name = $request->kyc_bank_account_holder_name;
        $detail->kyc_bank_account_number = $request->kyc_bank_account_number;
        $detail->kyc_bank_ifsc_code = strtoupper($request->kyc_bank_ifsc_code);
        $detail->save();
        $this->saveDocument($user->id, 'bank_proof', $request->file('bank_proof'));
        return true;
    }

    protected function storeProprietorshipStep5(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'address_1' => ['required', 'string', 'max:500'],
            'address_2' => ['nullable', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:25'],
            'state' => ['required', 'string', 'max:25'],
            'address_proof' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], [
            'address_1' => __('Address line 1'),
            'address_2' => __('Address line 2'),
            'city' => __('City'),
            'state' => __('State'),
            'address_proof' => __('Address Proof'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 5])->withInput()->withErrors($v);
        }
        $detail->address_1 = $request->address_1;
        $detail->address_2 = $request->address_2 ?: null;
        $detail->city = $request->city;
        $detail->state = $request->state;
        $detail->save();
        $this->saveDocument($user->id, 'address_proof', $request->file('address_proof'));
        return true;
    }

    protected function storeProprietorshipStep6(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'agreement' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['agreement' => __('Agreement')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.proprietorship.step', ['step' => 6])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'agreement', $request->file('agreement'));
        return true;
    }

    // ---------- Partnership: store step 1-6 ----------
    protected function storePartnershipStep1(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'firm_pan_number' => ['required', 'string', new PanNumber()],
            'firm_pan_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['firm_pan_number' => __('Firm PAN'), 'firm_pan_file' => __('Firm PAN Card')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 1])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'firm_pan', $request->file('firm_pan_file'), strtoupper(preg_replace('/\s+/', '', $request->firm_pan_number)));
        return true;
    }

    protected function storePartnershipStep2(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'partnership_deed' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
        ], [], ['partnership_deed' => __('Partnership Deed')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 2])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'partnership_deed', $request->file('partnership_deed'));
        return true;
    }

    protected function storePartnershipStep3(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'kyc_signatory_name' => ['required', 'string', 'max:191'],
            'kyc_signatory_phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'kyc_signatory_email' => ['required', 'email', 'max:191'],
        ], [], [
            'kyc_signatory_name' => __('Authorised Signatory name'),
            'kyc_signatory_phone' => __('Authorised Signatory mobile'),
            'kyc_signatory_email' => __('Authorised Signatory email'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 3])->withInput()->withErrors($v);
        }

        $partnersInput = $request->input('partners', []);
        $partnersFiles = $request->file('partners', []);
        if (empty($partnersInput) || !is_array($partnersInput)) {
            $this->helper->one_time_message('error', __('Add at least one partner with Aadhaar and PAN.'));
            return redirect()->route('user.kyc.partnership.step', ['step' => 3])->withInput();
        }

        $path = 'uploads/kyc-documents';
        $uploadPath = public_path($path);
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        try {
            DB::beginTransaction();
            KycPartner::where('user_id', $user->id)->delete();
            $sortOrder = 0;
            foreach (array_keys($partnersInput) as $i) {
                $p = array_merge($partnersInput[$i] ?? [], $partnersFiles[$i] ?? []);
                $name = trim($p['name'] ?? '');
                $aadhaar = preg_replace('/\s+/', '', $p['aadhaar_number'] ?? '');
                $pan = strtoupper(preg_replace('/\s+/', '', $p['pan_number'] ?? ''));
                if (empty($name) || strlen($aadhaar) !== 12 || strlen($pan) !== 10) {
                    continue;
                }
                $aadhaarFile = $p['aadhaar_file'] ?? null;
                $panFile = $p['pan_file'] ?? null;
                if (!$aadhaarFile instanceof \Illuminate\Http\UploadedFile || !$panFile instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }
                $extA = strtolower($aadhaarFile->getClientOriginalExtension());
                $uniqueA = $user->id . '_partner_' . $sortOrder . '_aadhaar_' . time() . '.' . $extA;
                $aadhaarFile->move($uploadPath, $uniqueA);
                $fileA = File::create(['user_id' => $user->id, 'filename' => $uniqueA, 'originalname' => $aadhaarFile->getClientOriginalName(), 'type' => $extA]);
                $extP = strtolower($panFile->getClientOriginalExtension());
                $uniqueP = $user->id . '_partner_' . $sortOrder . '_pan_' . time() . '.' . $extP;
                $panFile->move($uploadPath, $uniqueP);
                $fileP = File::create(['user_id' => $user->id, 'filename' => $uniqueP, 'originalname' => $panFile->getClientOriginalName(), 'type' => $extP]);
                KycPartner::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'aadhaar_number' => $aadhaar,
                    'aadhaar_file_id' => $fileA->id,
                    'pan_number' => $pan,
                    'pan_file_id' => $fileP->id,
                    'sort_order' => $sortOrder++,
                ]);
            }
            $count = KycPartner::where('user_id', $user->id)->count();
            if ($count < 1) {
                DB::rollBack();
                $this->helper->one_time_message('error', __('Add at least one partner with Aadhaar and PAN documents.'));
                return redirect()->route('user.kyc.partnership.step', ['step' => 3])->withInput();
            }
            $detail->kyc_signatory_name = $request->kyc_signatory_name;
            $detail->kyc_signatory_phone = $request->kyc_signatory_phone;
            $detail->kyc_signatory_email = $request->kyc_signatory_email;
            $detail->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->helper->one_time_message('error', $e->getMessage());
            return redirect()->route('user.kyc.partnership.step', ['step' => 3])->withInput();
        }
        return true;
    }

    protected function storePartnershipStep4(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'letter_authorizing_partner' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'bank_mandate' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['letter_authorizing_partner' => __('Letter authorizing one partner'), 'bank_mandate' => __('Bank mandate')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 4])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'letter_authorizing_partner', $request->file('letter_authorizing_partner'));
        $this->saveDocument($user->id, 'bank_mandate', $request->file('bank_mandate'));
        return true;
    }

    protected function storePartnershipStep5(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'kyc_bank_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_holder_name' => ['required', 'string', 'max:191'],
            'kyc_bank_account_number' => ['required', 'string', 'max:50'],
            'kyc_bank_ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'bank_cheque' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], [
            'kyc_bank_name' => __('Bank name'),
            'kyc_bank_account_holder_name' => __('Account holder name'),
            'kyc_bank_account_number' => __('Account number'),
            'kyc_bank_ifsc_code' => __('IFSC code'),
            'bank_cheque' => __('Partnership firm current account cheque'),
        ]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 5])->withInput()->withErrors($v);
        }
        $detail->kyc_bank_name = $request->kyc_bank_name;
        $detail->kyc_bank_account_holder_name = $request->kyc_bank_account_holder_name;
        $detail->kyc_bank_account_number = $request->kyc_bank_account_number;
        $detail->kyc_bank_ifsc_code = strtoupper($request->kyc_bank_ifsc_code);
        $detail->save();
        $this->saveDocument($user->id, 'bank_cheque', $request->file('bank_cheque'));
        return true;
    }

    protected function storePartnershipStep6(Request $request, $user, $detail)
    {
        $v = Validator::make($request->all(), [
            'agreement' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ], [], ['agreement' => __('Agreement')]);
        if ($v->fails()) {
            $this->helper->one_time_message('error', $v->errors()->first());
            return redirect()->route('user.kyc.partnership.step', ['step' => 6])->withInput()->withErrors($v);
        }
        $this->saveDocument($user->id, 'agreement', $request->file('agreement'));
        return true;
    }
}
