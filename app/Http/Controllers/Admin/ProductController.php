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
        $this->routePrefix = 'products';
        $this->tableData = ['id','name','image_tag','formatted_price','stock_status'];
        $this->tableHeaders = ['ID','Name','Image','Price','Stock status'];
        $this->title = 'Product';
    }

    public function store(Request $request): RedirectResponse
    {
        $product = app(ProductService::class, ['product' => new Product()])->create($this->myValidate($request));

        return redirect()->route($this->routePrefix . '.edit', $product->id)
            ->with('message', $this->title . ' has been created successfully!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->title]));
    }

    public function trash(): View
    {
        return view('admin.trash', [
            'posts' => Product::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10),
            'title' => ucfirst($this->routePrefix) . ' Table',
            'th' => $this->tableHeaders,
            'td' => $this->tableData,
            'essence' => $this->routePrefix,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::withTrashed()->findOrFail($id)])->restore();

        return redirect()->back()->with('message', $this->title . ' has been restored successfully!');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        app(ProductService::class, ['product' => Product::withTrashed()->findOrFail($id)])->forceDelete();

        return redirect()->back()->with('message', $this->title . ' has been deleted successfully!');
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
            'attributes' => 'nullable|array',
            'attributes.*' => 'numeric',
            'category' => 'nullable|array',
            'category.*' => 'numeric',
            'stock' => Rule::in(Product::PRODUCT_STOCK_STATUSES),
        ]);
    }
}
