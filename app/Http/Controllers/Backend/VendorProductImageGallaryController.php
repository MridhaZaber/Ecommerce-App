<?php

namespace App\Http\Controllers\Backend;


use App\DataTables\VendorProductImageGallaryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallary;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGallaryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VendorProductImageGallaryDataTable $dataTable)
    {
        if (request()->ajax()) {
            return $dataTable->ajax();
        }
        $product = Product::findOrFail($request->product);
        //check product vendor
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return $dataTable->render('vendor.product.image-gallary.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'image.*' => ['required', 'image', 'max:2048'],
        ]);
        /* imsge upload */

        $imagePaths = $this->uploadMultiImage($request, 'image', 'uploads');

        foreach ($imagePaths as $path) {
            $productImageGallary = new ProductImageGallary();
            $productImageGallary->image = $path;
            $productImageGallary->product_id = $request->product;
            $productImageGallary->save();
        }
        return redirect()->back()->with('success', 'Image Upload Succesfully!!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productImage = ProductImageGallary::findOrFail($id);
        //check product vendor
        if ($productImage->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        $this->deleteImage($productImage->image);
        $productImage->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!! ']);
    }
}
