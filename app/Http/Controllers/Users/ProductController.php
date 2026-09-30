<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show Activated and Available products (card layout) with request activation.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $userActivatedProductIds = UserProduct::where('user_id', $userId)->activated()->pluck('product_id')->toArray();
        $activated = Product::active()
            ->where(function ($q) use ($userActivatedProductIds) {
                $q->where('section', 'activated')->orWhereIn('id', $userActivatedProductIds);
            })
            ->orderBy('sort_order')->orderBy('title')->get();
        $availableProducts = Product::active()->available()->orderBy('sort_order')->orderBy('title')->get();
        $userProductMap = UserProduct::where('user_id', $userId)->whereIn('product_id', $availableProducts->pluck('id'))->get()->keyBy('product_id');
        $availableProductsWithStatus = $availableProducts->map(function ($product) use ($userProductMap) {
            $up = $userProductMap->get($product->id);
            return (object)['product' => $product, 'user_product' => $up, 'status' => $up ? $up->status : null];
        })->filter(function ($item) {
            return $item->status !== 'activated';
        })->values();

        return view('user.products.index', [
            'activated' => $activated,
            'availableProductsWithStatus' => $availableProductsWithStatus,
        ]);
    }

    /**
     * Request activation for a product (creates or resets to pending).
     */
    public function requestActivation(Request $request, Product $product)
    {
        if (!$product->is_active || $product->section !== 'available') {
            abort(404);
        }
        $user = $request->user();
        $userProduct = UserProduct::firstOrNew(['user_id' => $user->id, 'product_id' => $product->id]);
        $userProduct->status = 'pending';
        $userProduct->requested_at = now();
        $userProduct->reviewed_at = null;
        $userProduct->rejection_reason = null;
        $userProduct->save();

        (new \App\Http\Helpers\Common())->one_time_message('success', __('Activation requested. We will review and notify you.'));
        return redirect()->back();
    }
}
