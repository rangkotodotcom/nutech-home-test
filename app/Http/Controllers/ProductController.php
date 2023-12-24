<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', [
            'title'         => 'Tambah Produk',
            'categories'    => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id'       => 'required',
            'name'              => 'required|unique:products,name',
            'purchase_price'    => 'required|integer',
            'selling_price'     => 'required|integer',
            'stock'             => 'required|integer',
            'image'             => 'image|mimes:jpg,png|file|max:100',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {

            $image = $request->file('image');
            $imagename = Str::uuid()->toString() . '.' . $image->extension();

            $path = $request->file('image')->storeAs(
                'product',
                $imagename
            );

            $validatedData['image_name'] = $imagename;
            $validatedData['image_path'] = $path;
            unset($validatedData['image']);
        }

        $create = Product::create($validatedData);

        if ($create) {
            return redirect('/')->with('success', 'Produk Berhasil Ditambah');
        } else {
            return back()->with('error', 'Gagal Menambah Produk');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', [
            'title'         => 'Edit Produk',
            'categories'    => $categories,
            'product'       => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $rules = [
            'category_id'       => 'required',
            'purchase_price'    => 'required|integer',
            'selling_price'     => 'required|integer',
            'stock'             => 'required|integer',
        ];

        if ($request->name != $product->name) {
            $rules['name'] = 'required|unique:products,name';
        }

        if ($request->file('image')) {

            $rules['image'] = 'image|mimes:jpg,png|file|max:100';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $image = $request->file('image');
            $imagename = Str::uuid()->toString() . '.' . $image->extension();

            $path = $request->file('image')->storeAs(
                'product',
                $imagename
            );

            $validatedData['image_name'] = $imagename;
            $validatedData['image_path'] = $path;
            unset($validatedData['image']);
        }

        $create = Product::where('id', $product->id)
            ->update($validatedData);

        if ($create) {
            return redirect('/')->with('success', 'Produk Berhasil Diedit');
        } else {
            return back()->with('error', 'Gagal Mengedit Produk');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::delete($product->image_path);
        }

        Product::destroy($product->id);

        return redirect('/')->with('success', 'Produk Berhasil Dihapus');
    }
}
