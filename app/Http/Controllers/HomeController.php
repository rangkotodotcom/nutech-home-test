<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $product = Product::with('category')->get();
        return view('home.index', [
            'title'         => 'Dashboard',
            'categories'    => $categories,
            'product'       => $product
        ]);
    }
}
