<?php

namespace App\Http\Controllers;

use App\Exports\Product as ExportsProduct;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $product = Product::latest()->filter(request(['search', 'category']))->paginate(10)->withQueryString();
        return view('home.index', [
            'title'         => 'Dashboard',
            'categories'    => $categories,
            'product'       => $product
        ]);
    }

    public function export()
    {
        return Excel::download(new ExportsProduct, 'produk.xlsx');
    }
}
