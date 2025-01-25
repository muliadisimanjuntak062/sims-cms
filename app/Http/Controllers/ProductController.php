<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $products = Product::with('category');

            if ($request->has('product_category_id') && $request->product_category_id) {
                $products->where('product_category_id', $request->product_category_id);
            }

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('product_category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
                })
                ->addColumn('image', function ($product) {
                    return asset('storage/products/' . $product->image);
                })
                ->rawColumns(['product_category_name', 'image'])
                ->make();
        }
        $productCategories = ProductCategory::all();
        return view('products.index', compact('productCategories'));
    }

    public function create()
    {
        $productCategories = ProductCategory::all();

        return view('products.create', compact('productCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png|max:100',
            'name' => 'required|min:4',
            'product_category_id' => 'required|exists:product_categories,id',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric|gt:purchase_price',
            'stock' => 'required|numeric'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->sell_price < $request->purchase_price * 1.3) {
                $validator->errors()->add('sell_price', 'The selling price must be at least 30% higher than the purchase price.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        Product::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'purchase_price' => $request->purchase_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock
        ]);

        return redirect()->route('products.index')->with(['success' => 'Berhasil menambah produk!']);
    }

    public function edit($productId)
    {
        $product = Product::where('id', $productId)->first();
        $productCategories = ProductCategory::all();

        return view('products.edit', compact('product', 'productCategories'));
    }

    public function update(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpg,png|max:100',
            'name' => 'required|min:4',
            'product_category_id' => 'required|exists:product_categories,id',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric|gt:purchase_price',
            'stock' => 'required|numeric'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->sell_price < $request->purchase_price * 1.3) {
                $validator->errors()->add('sell_price', 'The selling price must be at least 30% higher than the purchase price.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($productId);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
            }

            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            $product->image = $image->hashName();
        }

        $product->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'purchase_price' => $request->purchase_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
            'image' => $product->image, // Ensure image is set (if uploaded)
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->image && Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    
}
