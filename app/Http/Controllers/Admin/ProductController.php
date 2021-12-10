<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends CRUDController
{
    public function __construct()
    {
        $this->model = Product::class;
        $this->essense = 'products';
        $this->td = ['id','name','image_tag','formatted_price','stock_status'];
        $this->th = ['ID','Name','Image','Price','Stock status'];
        $this->oneText = 'Product';
    }

    public function store(Request $request): RedirectResponse
    {
        $product = app(ProductService::class, ['product' => new Product()])->updateOrFill($this->myValidate($request));

        return redirect()->route($this->essense . '.edit', $product->id)
            ->with('message', $this->oneText . ' has been created successfully!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::findOrFail($id)])->updateOrFill($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->oneText]));
    }

    public function trash(): View
    {
        return view('admin.trash', [
            'posts' => Product::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10),
            'title' => ucfirst($this->essense) . ' Table',
            'th' => $this->th,
            'td' => $this->td,
            'essence' => $this->essense,
        ]);
    }

    public function restore($id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::withTrashed()->findOrFail($id)])->restore();

        return redirect()->back()->with('message', $this->oneText . ' has been restored successfully!');
    }

    public function forceDelete($id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::withTrashed()->findOrFail($id)])->forceDelete();

        return redirect()->back()->with('message', $this->oneText . ' has been deleted successfully!');
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'image_id' => 'nullable|numeric',
            'gallery' => 'nullable|string',
            'price' => 'required|numeric',
            'details' => 'nullable|string',
            'description' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*' => 'numeric',
            'category' => 'array',
            'category.*' => 'numeric',
            'stock' => Rule::in(Product::PRODUCT_STOCK_STATUSES),
        ]);
    }
}
