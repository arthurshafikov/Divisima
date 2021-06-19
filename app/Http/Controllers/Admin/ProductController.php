<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $this->myValidate($request);
        $product = $this->model::create($request->all());

        if ($gallery = $request->gallery) {
            $product->images()->sync(explode(',', $gallery));
        }
        $product->attributes()->sync($request->get('attributes'));
        $product->category()->sync($request->get('category'));
        return redirect()->route($this->essense . '.edit', $product->id)
                            ->with('message', $this->oneText . ' has been created successfully!');
    }

    public function update(Request $request, $id)
    {
        $this->myValidate($request);
        $product = $this->model::findOrFail($id);
        $product->update($request->all());

        if ($gallery = $request->gallery) {
            $product->images()->sync(explode(',', $gallery));
        }
        $product->attributes()->sync($request->get('attributes'));
        $product->category()->sync($request->get('category'));
        return redirect()->back()->with('message', $this->oneText . ' has been updated successfully!');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);

        return view('admin.trash', [
            'posts' => $products,
            'title' => ucfirst($this->essense) . ' Table',
            'th' => $this->th,
            'td' => $this->td,
            'essence' => $this->essense,
        ]);
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->back()->with('message', $this->oneText . ' has been restored successfully!');
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->back()->with('message', $this->oneText . ' has been deleted successfully!');
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'img' => 'nullable',
            'gallery' => 'nullable|string',
            'price' => 'required|numeric',
            'attributes' => 'array',
            'category' => 'array',
            'stock' => 'integer',
        ]);
    }
}
