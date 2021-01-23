<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::orderBy('updated_at', 'desc')->paginate(8),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveProductRequest $request
     * @return RedirectResponse
     */
    public function store(SaveProductRequest $request): RedirectResponse
    {
        $product = new Product();
        $this->saveProduct($request, $product, 'created');
        return redirect()->route('admin.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit',
            ['product' => $product, 'categories' => Category::all()]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(SaveProductRequest $request, Product $product): RedirectResponse
    {
        $this->saveProduct($request, $product, 'updated');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        Storage::delete($product->photo);
        $product->delete();
        Alert::success(__('admin.products.deleted'));
        return back();
    }

    /**
     * Change the specified product status.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function changeProductStatus(Product $product): RedirectResponse
    {
        $product->update([
            'status' => $product->status === Product::STATUSES['available']
                ? Product::STATUSES['unavailable']
                : Product::STATUSES['available']
        ]);
        $message = $product->status === Product::STATUSES['available']
            ? 'enabled' : 'disabled';
        Alert::success(__("admin.products.{$message}"));
        return back();
    }

    /**
     * Save the specified resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @param string $message
     * @return void
     */
    public function saveProduct(SaveProductRequest $request, Product $product, string $message): void
    {
        $product->fill(array_filter($request->validated()));
        if ($request->hasFile('photo')) {
            $product->photo = $request->file('photo')->store('img');
        }
        $product->save();
        Alert::success(__("admin.products.{$message}"));
    }
}
