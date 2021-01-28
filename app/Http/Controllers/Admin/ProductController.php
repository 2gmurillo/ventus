<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Verify if user can create a product.
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Product::class);
        return view('admin.products.index', [
            'products' => Product::getCachedAdminProducts(),
            'categories' => Category::getCachedCategories(),
        ]);
    }

    /**
     * Verify if user can create a product.
     * Store a newly created resource in storage.
     *
     * @param SaveProductRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SaveProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);
        $product = new Product();
        $this->saveProduct($request, $product, 'created');
        return redirect()->route('admin.products.index');
    }

    /**
     * Verify if user can update a product.
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', Product::class);
        return view(
            'admin.products.edit',
            ['product' => $product, 'categories' => Category::all()]
        );
    }

    /**
     * Verify if user can update a product.
     * Update the specified resource in storage.
     *
     * @param SaveProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(SaveProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', Product::class);
        $this->saveProduct($request, $product, 'updated');
        return redirect()->route('admin.products.index');
    }

    /**
     * Verify if user can delete a product.
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', Product::class);
        Storage::delete($product->photo);
        $product->delete();
        Product::flushCache();
        Alert::success(__('admin.products.deleted'));
        return back();
    }

    /**
     * Verify if user can update a product.
     * Change the specified product status.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function changeProductStatus(Product $product): RedirectResponse
    {
        $this->authorize('update', Product::class);
        $product->update([
            'status' => $product->status === Product::STATUSES['available']
                ? Product::STATUSES['unavailable']
                : Product::STATUSES['available']
        ]);
        Product::flushCache();
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
        Product::flushCache();
        Alert::success(__("admin.products.{$message}"));
    }
}
