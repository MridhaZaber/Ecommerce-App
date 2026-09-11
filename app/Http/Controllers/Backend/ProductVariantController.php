<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductVariantDataTable $dataTable)
    {
        if (request()->ajax()) {
            return $dataTable->ajax();
        }
        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'product' => ['integer', 'required'],
            'name' => ['required', 'max:100'],
            'status' => ['required']
        ]);

        $variant = new ProductVariant();
        $variant->product_id = $request->product;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        return redirect()->route('admin.products-variant.index', ['product' => $request->product])->with('success', 'Variant Create Succesfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'name' => ['required', 'max:100'],
            'status' => ['required']
        ]);

        $variant = ProductVariant::findOrFail($id);

        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        return redirect()->route('admin.products-variant.index', ['product' => $variant->product_id])->with('success', 'Variant Update Succesfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $variant = ProductVariant::findOrFail($id);
        $variantItemCheck = ProductVariantItem::where('product_variant_id', $variant->id)->count();
        if ($variantItemCheck > 0) {
            return response(['status' => 'error', 'message' => 'This variant contains item in it delete the variant first for delete this variant  ']);
        }
        $variant->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!! ']);
    }
    public function changeStatus(Request $request)
    {
        $category = ProductVariant::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
        return response(['status' => 'success', 'message' => 'Status has been Successfully Changed!! ']);
    }
}
