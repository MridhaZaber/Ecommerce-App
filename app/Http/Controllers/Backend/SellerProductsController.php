<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductDataTable;
use App\DataTables\SellerProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductsController extends Controller
{


    public function index(SellerProductsDataTable $dataTable)
    {
        if (request()->ajax()) {
            return $dataTable->ajax();
        }
        return $dataTable->render('admin.product.seller-product.index');
    }

    public function pendingProducts(SellerPendingProductDataTable $dataTable)
    {

        if (request()->ajax()) {
            return $dataTable->ajax();
        }
        return $dataTable->render('admin.product.seller-pending-product.index');
    }

    public function changeApprovedStatus(Request $request) {
        $product=Product::findOrFail($request->id);
        $product->is_apporved=$request->value;
        $product->save();
        return response(['message'=>'Product Approved Has been change']);

    }
}
