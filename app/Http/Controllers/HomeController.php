<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of filtered products.
     *
     * @param FilterRequest $request
     * @return Application|Factory|View
     */
    public function index(FilterRequest $request): View
    {
        $categorySelected = $request->category_selected;
        $orderBy = $request->order_by;
        $search = $request->search;
        $products = Product::with('category')
            ->available()
            ->categorySelect($categorySelected)
            ->orderBySelect($orderBy)
            ->search($search)
            ->paginate(8);

        return view('home', [
            'products' => $products,
            'categorySelected' => $categorySelected,
            'orderBy' => $orderBy,
            'search' => $search,
            'categories' => Category::getCachedCategories(),
        ]);
    }
}
