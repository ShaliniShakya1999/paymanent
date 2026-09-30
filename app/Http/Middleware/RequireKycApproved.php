<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireKycApproved
{
    /**
     * Routes that are allowed without KYC approval (onboarding flow).
     *
     * @var array<string>
     */
    protected $kycRoutes = [
        'user.kyc.category',
        'user.kyc.category.store',
        'user.kyc.individual.*',
        'user.kyc.proprietorship.*',
        'user.kyc.partnership.*',
        'user.kyc.under-review',
        'user.kyc.rejected',
        'user.logout',
    ];

    /**
     * Handle an incoming request.
     * Block dashboard access until KYC is approved; redirect to appropriate onboarding step.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isKycRoute($request)) {
            return $next($request);
        }

        $user = $request->user();
        if (!$user) {
            return $next($request);
        }

        $detail = $user->user_detail;
        if (!$detail) {
            return redirect()->route('user.kyc.category');
        }

        $kycStatus = $detail->kyc_status ?? 'pending';
        $merchantCategory = $detail->merchant_category;

        // Not started: must select merchant category
        if (empty($merchantCategory)) {
            return redirect()->route('user.kyc.category');
        }

        switch ($kycStatus) {
            case 'in_review':
                return redirect()->route('user.kyc.under-review');
            case 'rejected':
                return redirect()->route('user.kyc.rejected');
            case 'approved':
                return $next($request);
            case 'pending':
            default:
                return redirect()->route("user.kyc.{$merchantCategory}.step", ['step' => 1]);
        }
    }

    /**
     * Check if the current route is part of KYC onboarding (allowed without approval).
     */
    protected function isKycRoute(Request $request): bool
    {
        $name = $request->route()?->getName();
        if (!$name) {
            return false;
        }

        foreach ($this->kycRoutes as $pattern) {
            if (str_ends_with($pattern, '.*')) {
                if (str_starts_with($name, rtrim($pattern, '.*'))) {
                    return true;
                }
            }
            if ($name === $pattern) {
                return true;
            }
        }

        return false;
    }
}
