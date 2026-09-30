<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $helper;

    public function __construct(Common $helper)
    {
        $this->helper = $helper;
    }

    public function index()
    {
        $data['menu'] = 'products';
        $data['sub_menu'] = 'products_list';
        $data['products'] = Product::orderBy('section')->orderBy('sort_order')->orderBy('title')->paginate(20);
        return view('admin.products.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'products';
        $data['sub_menu'] = 'products_list';
        $data['product'] = null;
        return view('admin.products.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'section' => ['required', 'in:activated,available'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'title' => __('Title'),
            'description' => __('Description'),
            'icon_class' => __('Icon class'),
            'section' => __('Section'),
        ]);

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon_class' => $request->icon_class ?: null,
            'section' => $request->section,
            'sort_order' => (int) $request->get('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->helper->one_time_message('success', __('Product added successfully.'));
        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $data['menu'] = 'products';
        $data['sub_menu'] = 'products_list';
        $data['product'] = Product::findOrFail($id);
        return view('admin.products.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'section' => ['required', 'in:activated,available'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'title' => __('Title'),
            'description' => __('Description'),
            'icon_class' => __('Icon class'),
            'section' => __('Section'),
        ]);

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon_class' => $request->icon_class ?: null,
            'section' => $request->section,
            'sort_order' => (int) $request->get('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->helper->one_time_message('success', __('Product updated successfully.'));
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->helper->one_time_message('success', __('Product deleted successfully.'));
        return redirect()->route('admin.products.index');
    }
}
