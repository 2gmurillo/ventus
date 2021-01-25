<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Category;
use App\Models\Product;

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
     */
    public function index(FilterRequest $request)
    {
        $categorySelected = $request->category_selected;
        $orderBy = $request->order_by;
        $search = $request->search;
        $products = Product::with('category')
            ->category($categorySelected)
            ->order($orderBy)
            ->search($search)
            ->paginate(8);

        return view('home', [
            'products' => $products,
            'categorySelected' => $categorySelected,
            'orderBy' => $orderBy,
            'search' => $search,
            'categories' => Category::all(),
        ]);
    }
}
