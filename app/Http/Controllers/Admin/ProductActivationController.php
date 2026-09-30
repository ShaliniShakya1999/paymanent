<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class ProductActivationController extends Controller
{
    protected $helper;

    public function __construct(Common $helper)
    {
        $this->helper = $helper;
    }

    public function index(Request $request)
    {
        $data['menu'] = 'products';
        $data['sub_menu'] = 'product_activation_requests';

        $query = UserProduct::with(['user:id,first_name,last_name,email', 'product:id,title,description'])
            ->pending()
            ->orderBy('requested_at', 'desc');

        $data['requests'] = $query->paginate(20);

        return view('admin.products.activation_requests', $data);
    }

    public function approve($id)
    {
        $userProduct = UserProduct::with('user', 'product')->findOrFail($id);
        if ($userProduct->status !== 'pending') {
            $this->helper->one_time_message('error', __('This request is no longer pending.'));
            return redirect()->route('admin.product-activation.index');
        }

        $userProduct->status = 'activated';
        $userProduct->reviewed_at = now();
        $userProduct->rejection_reason = null;
        $userProduct->save();

        $this->helper->one_time_message('success', __('Product activation approved.'));
        return redirect()->route('admin.product-activation.index');
    }

    public function reject(Request $request, $id)
    {
        $userProduct = UserProduct::with('user', 'product')->findOrFail($id);
        if ($userProduct->status !== 'pending') {
            $this->helper->one_time_message('error', __('This request is no longer pending.'));
            return redirect()->route('admin.product-activation.index');
        }

        $reason = $request->validate(['rejection_reason' => ['nullable', 'string', 'max:500']])['rejection_reason'] ?? null;

        $userProduct->status = 'rejected';
        $userProduct->reviewed_at = now();
        $userProduct->rejection_reason = $reason;
        $userProduct->save();

        $this->helper->one_time_message('success', __('Product activation rejected.'));
        return redirect()->route('admin.product-activation.index');
    }
}
