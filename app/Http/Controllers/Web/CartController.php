<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id))
        {
            $check_cart_product = DB::table('cart')
                ->where('user_id', Auth::guard('users')->user()->id)
                ->where('product_id', $request->input('product_id'))
                ->count();

            if ($check_cart_product < 1 ) {

                $product_stock = DB::table('product')
                    ->where('id', $request->input('product_id'))
                    ->where('product.deleted_at', NULL)
                    ->first();

                if(($product_stock->stock >= $request->input('quantity')) && ($request->input('product_price') > 0)){
                    DB::table('cart')
                        ->insert([
                            'user_id' => Auth::guard('users')->user()->id,
                            'product_type' =>  $request->input('product_type'),
                            'product_id' =>  $request->input('product_id'),
                            'quantity' => (int)$request->input('quantity'),
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                } else 
                    return redirect()->back()->with('msg', 'Required quantity not available');
            } else {

                $product_stock = DB::table('product')
                    ->where('id', $request->input('product_id'))
                    ->where('product.deleted_at', NULL)
                    ->first();

                if(($product_stock->stock >= $request->input('quantity')) && ($request->input('product_price') > 0)){
                    DB::table('cart')
                        ->where('user_id', Auth::guard('users')->user()->id)
                        ->where('product_id', $request->input('product_id'))
                        ->increment('quantity', (int)$request->input('quantity'));
                } else 
                    return redirect()->back()->with('msg', 'Required quantity not available');
            }
        }
        else
        {
            $product_stock = DB::table('product')
                ->where('id', $request->input('product_id'))
                ->where('product.deleted_at', NULL)
                ->first();

            if (($request->input('quantity') > 0) && ($request->input('product_price') > 0) && ($product_stock->stock >= $request->input('quantity'))){
                if (empty(Session::get('cart')))
                    $cart = array();
                else
                    $cart = Session::get('cart');

                if(isset($cart[$request->input('product_id')])){

                    $product_type = explode(',', $cart[$request->input('product_id')]);
                    $quantity = current($product_type);

                    $cart[$request->input('product_id')] = ($quantity + $request->input('quantity')).",".$request->input('product_type');
                } else 
                    $cart[$request->input('product_id')] = $request->input('quantity').",".$request->input('product_type');

                Session::put('cart', $cart);
                Session::save();
            } else
                return redirect()->back()->with('msg', 'Required quantity not available');
        }

        return redirect()->route('web.view_cart');
    }

    public function viewCart()
    {
    	$cart_data = [];
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) 
        {
            $user_id = Auth::guard('users')->user()->id;

            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
                            
                    $product_cnt = DB::table('product')
                        ->where('product.id', $cart[$i]->product_id)
                        ->where('product.status', 0)
                        ->count();

                    if($product_cnt > 0) {
                        DB::table('cart')
                            ->where('user_id', $user_id)
                            ->where('cart.product_id', $cart[$i]->product_id)
                            ->delete();
                    }
                }
            }

            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
                    if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                        $product = DB::table('product')
                            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                            ->where('product.id', $cart[$i]->product_id)
                            ->where('product.status', 1)
                            ->where('product.deleted_at', NULL)
                            ->where('product_type_price.type', $cart[$i]->product_type)
                            ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                            ->distinct()
                            ->first();

                        $type = "";

                        if ($cart[$i]->product_type == 1)
                            $type = "Ready to wear";
                        else
                            $type = "Raw";

                        $cart_data[] = [
                            'product_id' => $product->id,
                            'slug' => $product->slug,
                            'product_name' => $product->product_name,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount,
                            'product_type' => $type
                        ];
                    } 

                    if($cart[$i]->product_type == 3) {

                        $product = DB::table('cart')
                            ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                            ->where('cart.product_id', $cart[$i]->product_id)
                            ->where('cart.product_type', 3)
                            ->where('product.status', 1)
                            ->where('product.deleted_at', NULL)
                            ->select('product.*')
                            ->distinct()
                            ->first();

                        $type = "";

                        $cart_data[] = [
                            'product_id' => $product->id,
                            'slug' => $product->slug,
                            'product_name' => $product->product_name,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount,
                            'product_type' => 'Metal'
                        ];
                    } 
                }
            }
        } 
        else 
        {
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');

                if (count($cart) > 0) {
                    foreach ($cart as $product_id => $item) {
                                
                        if (!empty($product_id)) {
                            $product_cnt = DB::table('product')
                                ->where('product.id', $product_id)
                                ->where('product.status', 0)
                                ->count();

                                // dd($product_cnt);

                            if($product_cnt > 0){
                                Session::forget('cart.'.$product_id);
                            }
                        }
                    }
                }

                if (count($cart) > 0) {
                    foreach ($cart as $product_id => $item) {
                                
                        if (!empty($product_id)) {
                            $product_cnt = DB::table('product')
                                ->where('product.id', $product_id)
                                ->where('product.deleted_at', '!=', NULL)
                                ->count();

                                // dd($product_cnt);

                            if($product_cnt > 0){
                                Session::forget('cart.'.$product_id);
                            }
                        }
                    }
                }

                $cart = Session::get('cart');
                if (count($cart) > 0) {
                    foreach ($cart as $product_id => $item) {

                        if (!empty($product_id)) {

                            $product_type = explode(',', $item);
                            $quantity = current($product_type);
                            $product_type = end($product_type);

                            if(($product_type == 1) || ($product_type == 2)) {
                                
                                $product = DB::table('product')
                                    ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                    ->where('product.id', $product_id)
                                    ->where('product_type_price.type', $product_type)
                                    ->where('product.deleted_at', NULL)
                                    ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                    ->distinct()
                                    ->first();

                                $type = "";
                                if ($product_type == 1)
                                    $type = "Ready to wear";
                                else
                                    $type = "Raw";

                                $cart_data[] = [
                                    'product_id' => $product_id,
                                    'slug' => $product->slug,
                                    'product_name' => $product->product_name,
                                    'price' => (int)$product->customer_price,
                                    'seller_price' => (int)$product->distributor_price,
                                    'quantity' => (int)$quantity,
                                    'discount' => $product->discount,
                                    'product_type' => $type
                                ];
                            }

                            if($product_type == 3) {

                                $product = DB::table('product')
                                    ->where('product.id', $product_id)
                                    ->where('product.deleted_at', NULL)
                                    ->select('product.*')
                                    ->distinct()
                                    ->first();

                                $cart_data[] = [
                                    'product_id' => $product_id,
                                    'slug' => $product->slug,
                                    'product_name' => $product->product_name,
                                    'price' => $product->customer_price,
                                    'seller_price' => $product->distributor_price,
                                    'quantity' => $quantity,
                                    'discount' => $product->discount,
                                    'product_type' => 'Metal'
                                ];
                            } 
                        }
                    }
                }
            }
        }

        return view('web.cart.view_cart', compact('cart_data'));
    }

    public function removeCartItem($product_id)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) 
        {
            DB::table('cart')
                ->where('user_id', Auth::guard('users')->user()->id)
                ->where('product_id', $product_id)
                ->delete();
        }
        else
        {
            if(Session::has('cart') && !empty(Session::get('cart'))){
                Session::forget('cart.'.$product_id);
            }
        }

        return redirect()->route('web.view_cart');
    }

    public function updateCart(Request $request)
    {
        if( Auth::guard('users')->user() && !empty(Auth::guard('users')->user()->id)) 
        {
            if (count($request->input('product_id')) > 0) {
                for($i = 0; $i < count($request->input('product_id')); $i++) {
                    $check_cart_product = DB::table('cart')
                        ->where('user_id', Auth::guard('users')->user()->id)
                        ->where('product_id', $request->input('product_id')[$i])
                        ->count();

                    if ($check_cart_product > 0) {

                        $product_stock = DB::table('product')
                                ->where('id', $request->input('product_id')[$i])
                                ->first();

                        $product_quantity_status = 0;
                            
                        if(($request->input('quantity')[$i] > 0) &&($product_stock->stock >= $request->input('quantity')[$i])){

                            DB::table('cart')
                                ->where('user_id', Auth::guard('users')->user()->id)
                                ->where('product_id', $request->input('product_id')[$i])
                                ->update([
                                    'quantity' => (int)$request->input('quantity')[$i],
                                ]);
                        } else {
                            $product_quantity_status = 1;
                        }
                    }
                }

                if($product_quantity_status == 1)
                    return redirect()->back()->with('msg', 'product quantity not available for some item.');
            }
        }
        else
        {
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');
                if (count($cart) > 0) {
                    $i = 0;
                    foreach ($cart as $product_id => $item) {

                        if(!empty($product_id))
                        {
                            $product_type = explode(',', $item);
                            $quantity = current($product_type);
                            $product_type = end($product_type);

                            $product_stock = DB::table('product')
                                ->where('id', $product_id)
                                ->first();

                            $product_quantity_status = 0;
                            
                            if(($request->input('quantity')[$i] > 0) &&($product_stock->stock >= $request->input('quantity')[$i])){
                                $cart[$product_id] = $request->input('quantity')[$i].",".$product_type;
                            } else {
                                $product_quantity_status = 1;
                            }

                            $i++;
                        }
                    }
                }

                Session::put('cart', $cart);
                Session::save();

                if($product_quantity_status == 1)
                    return redirect()->back()->with('msg', 'product quantity not available for some item.');
            }
        }

        return redirect()->route('web.view_cart');
    }
}
