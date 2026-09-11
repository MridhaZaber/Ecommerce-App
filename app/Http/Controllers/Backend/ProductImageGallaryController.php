<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGallaryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallary;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGallaryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductImageGallaryDataTable $dataTable)
    {
        //

        if (request()->ajax()) {
            return $dataTable->ajax();
        }
        $product = Product::findOrFail($request->product);

        return $dataTable->render('admin.product.image-gallary.index', compact('product'));
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
        $priductImage = ProductImageGallary::findOrFail($id);
        $this->deleteImage($priductImage->image);
        $priductImage->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!! ']);
    }
}
