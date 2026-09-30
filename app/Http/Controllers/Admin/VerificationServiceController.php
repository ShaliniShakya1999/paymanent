<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationLog;
use Illuminate\Http\Request;

class VerificationServiceController extends Controller
{
    protected static $typeMap = [
        'pan-ocr' => 'pan_ocr',
        'pan-details' => 'pan_details',
        'gst' => 'gst',
        'mca' => 'mca',
        'aadhaar-otp' => 'aadhaar_otp',
    ];

    protected static $subMenuMap = [
        'pan-ocr' => 'verification_pan_ocr',
        'pan-details' => 'verification_pan_details',
        'gst' => 'verification_gst',
        'mca' => 'verification_mca',
        'aadhaar-otp' => 'verification_aadhaar',
    ];

    public function index(Request $request, string $type = 'pan-ocr')
    {
        $typeKey = self::$typeMap[$type] ?? $type;
        $query = VerificationLog::with('user:id,first_name,last_name,email')
            ->where('type', $typeKey);
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $logs = $query->orderByDesc('id')->paginate(20)->withQueryString();
        return view('admin.verification.index', [
            'menu' => 'verification_services',
            'sub_menu' => self::$subMenuMap[$type] ?? 'verification_pan_ocr',
            'logs' => $logs,
            'type' => $type,
            'typeLabel' => ucwords(str_replace(['-', '_'], ' ', $type)),
            'from' => $request->from,
            'to' => $request->to,
        ]);
    }
}
