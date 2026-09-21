<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function clearCart()
    {
        Cart::destroy();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully',
            'cart_count' => Cart::countItems(),
            'cart' => Cart::content(),
        ]);
    }
    /*Add item to cart */

    /** Add item to cart */
    public function addToCart(Request $request)
    {

        $product = Product::findOrFail($request->product_id);

        $variants = [];
        $variantTotalAmount = 0;

        if($request->has('variants_items')){
            foreach($request->variants_items as $item_id){
                $variantItem = ProductVariantItem::find($item_id);
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $variantTotalAmount += $variantItem->price;
            }
        }


        /** check discount */
        $productPrice = 0;

        if(checkDiscount($product)){
            $productPrice = $product->offer_price;
        }else {
            $productPrice = $product->price;
        }
         $qty = (int) ($request->qty ?? 1);

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;


        Cart::add($cartData);

        return response(['status' => 'success', 'message' => 'Added to cart successfully!']);
    }

    /**show cart page */

    public function cartDetails(){
        $cartItems=Cart::content();

        return view('frontend.pages.cart-detail',compact('cartItems'));
    }

    /**Update product quantity */
    public function updateProductQty(Request $request){
        Cart::update($request->rowId,$request->quantity);
        return response(['status'=>'success','message'=>'Product Quantity Updates']);
    }
}
