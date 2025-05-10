<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('products.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $product = Product::updateOrCreate(
            ['id' => $request->product_id],
            [
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function getProducts()
    {
        $products = Product::with('category')->get();
        return DataTables::of($products)
        ->addIndexColumn() 
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
            $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

}