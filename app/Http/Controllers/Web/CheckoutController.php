<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use Response;
use App\Mail\OrderEmail;
use Mail;
use Image;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
    	$check_cart_product = DB::table('cart')
            ->where('user_id', Auth::guard('users')->user()->id)
            ->count();

        if ($check_cart_product > 0) {

            $cart_product = DB::table('cart')
                ->where('user_id', Auth::guard('users')->user()->id)
                ->get();

            $product_quantity_status = 0;
            foreach ($cart_product as $key => $item) {

                $product_stock = DB::table('product')
                    ->where('id', $item->product_id)
                    ->first();

                if($product_stock->stock >= $item->quantity){

                } else {
                    $product_quantity_status = 1;
                }
            }

            if($product_quantity_status == 1){

                return redirect()->route('web.view_cart')->with('msg', 'product quantity not available for some item.');
            }

            $all_address = DB::table('address')
                ->where('user_id', Auth()->user()->id)
                ->where('status', 1)
        		->orderBY('id', 'DESC')
        		->get();

            $cart_data = [];
            $user_id = Auth::guard('users')->user()->id;
            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            $shipping_amount = 0;
            $total_quantity = 0;
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
                    if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                        $product = DB::table('product')
                            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                            ->where('product.id', $cart[$i]->product_id)
                            ->where('product_type_price.type', $cart[$i]->product_type)
                            ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                            ->distinct()
                            ->first();

                        $shipping_amount = $shipping_amount + ($product->shipping_amount * $cart[$i]->quantity);

                        $cart_data[] = [
                            'product_id' => $cart[$i]->product_id,
                            'product_id' => $product->id,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount
                        ];
                    } 

                    if($cart[$i]->product_type == 3) {

                        $product = DB::table('cart')
                            ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                            ->where('cart.product_id', $cart[$i]->product_id)
                            ->where('cart.product_type', 3)
                            ->select('product.*')
                            ->distinct()
                            ->first();

                        $shipping_amount = $shipping_amount + (((int)$product->shipping_amount * $product->weight) * $cart[$i]->quantity);

                        $cart_data[] = [
                            'product_id' => $cart[$i]->product_id,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount
                        ];
                    } 

                    $total_quantity =  $total_quantity + $cart[$i]->quantity;
                }
            }

            $old_orders = DB::table('order')
                ->where('user_id', $user_id)
                ->where('payment_status', 2)
                ->orWhere('payment_status', NULL)
                ->count();

            /** Cart Quantity **/
            $cart_quantity_set = DB::table('cart_quantity_for_seller')
                ->first();

            if(Auth::guard('users')->user()->user_role == 2){

                // $check_cart_product_quantity = 0;
                // for ($i = 0; $i < count($cart); $i++) {

                //     if($cart[$i]->quantity >= $cart_quantity_set->qty){
                //         $check_cart_product_quantity = 1;
                //     }
                // }
                
                if ((count($cart) >= $cart_quantity_set->qty) || ($total_quantity >= $cart_quantity_set->qty)) {
                    $total = 0;
                    foreach ($cart_data as $key => $item) {

                        if (!empty($item['discount'])) {
                            $discount = ($item['seller_price']*$item['discount']) / 100;
                            $selling_price = $item['seller_price'] - $discount;
                        } else {
                            $selling_price = $item['seller_price'];
                        }

                        $total_amount = ($selling_price * $item['quantity']);

                        $total = $total_amount + $total;
                    }
                } else {
                    $total = 0;
                    foreach ($cart_data as $key => $item) {

                        if (!empty($item['discount'])) {
                            $discount = ($item['price']*$item['discount']) / 100;
                            $selling_price = $item['price'] - $discount;
                        } else {
                            $selling_price = $item['price'];
                        }

                        $total_amount = ($selling_price * $item['quantity']);

                        $total = $total_amount + $total;
                    }
                }
            } else {
                $total = 0;
                foreach ($cart_data as $key => $item) {

                    if (!empty($item['discount'])) {
                        $discount = ($item['price']*$item['discount']) / 100;
                        $selling_price = $item['price'] - $discount;
                    } else {
                        $selling_price = $item['price'];
                    }

                    $total_amount = ($selling_price * $item['quantity']);

                    $total = $total_amount + $total;
                }
            }

            /** Coupons **/
            $coupon = DB::table('coupon');

            if((Auth::user()->user_role == 2) && !empty(Auth::user())){

                $coupon = $coupon
                    ->where('user_type', 2)
                    ->where('status', 1);
                    
            } else {

                $coupon = $coupon
                    ->where('user_type', 1)
                    ->where('status', 1);
            }

            $coupon = $coupon
                ->get();


        	return view('web.checkout.checkout', ['all_address' => $all_address, 'total' => $total, 'shipping_amount' => $shipping_amount, 'coupon' => $coupon, 'old_orders' => $old_orders]);
        } else
            return redirect()->route('web.index');
    }

    public function checkCoupon(Request $request) {
        
        $coupon_cnt = DB::table('coupon')
            ->where('coupon_code', $request->input('coupon_code'))
            ->count();

        if ($coupon_cnt > 0) {

            $coupon_data = DB::table('coupon')
                ->where('coupon_code', $request->input('coupon_code'));

            if((Auth::user()->user_role == 2) && !empty(Auth::user())){

                $coupon_data = $coupon_data
                    ->where('user_type', 2)
                    ->where('status', 1);
            } else {

                $coupon_data = $coupon_data
                    ->where('user_type', 1)
                    ->where('status', 1);
            }

            $coupon_data = $coupon_data
                ->first();

            if ($coupon_data->coupon_type == 1) {
                
                $order_cnt_1 = DB::table('order')
                    ->where('user_id', Auth::guard('users')->user()->id)
                    ->where('payment_status', 2)
                    ->count();

                $order_cnt_2 = DB::table('order')
                    ->where('user_id', Auth::guard('users')->user()->id)
                    ->where('payment_status', NULL)
                    ->count();

                $order_cnt = $order_cnt_1 + $order_cnt_2;

                if ($order_cnt > 0) {
                    print "Invalid Code";
                } else {
                    $coupon_discount = ($request->input('total_amount') * $coupon_data->coupon_amount) / 100;
                    print $coupon_discount;
                }
            } else {
                $order_cnt_1 = DB::table('order')
                    ->where('user_id', Auth::guard('users')->user()->id)
                    ->where('payment_status', 2)
                    ->count();

                $order_cnt_2 = DB::table('order')
                    ->where('user_id', Auth::guard('users')->user()->id)
                    ->where('payment_status', NULL)
                    ->count();

                $order_cnt = $order_cnt_1 + $order_cnt_2;

                if ($order_cnt > 0) {
                    $coupon_discount = ($request->input('total_amount') * $coupon_data->coupon_amount) / 100;
                    print $coupon_discount;
                } else {
                    print "Invalid Code";
                }
            }
        } else
            print "Invalid Code";
    }

    public function placeOrder(Request $request)
    {
        $check_cart_product = DB::table('cart')
            ->where('user_id', Auth::guard('users')->user()->id)
            ->count();

        if ($check_cart_product > 0) {

            $cart_product = DB::table('cart')
                ->where('user_id', Auth::guard('users')->user()->id)
                ->get();

            $product_quantity_status = 0;
            foreach ($cart_product as $key => $item) {

                $product_stock = DB::table('product')
                    ->where('id', $item->product_id)
                    ->first();

                if($product_stock->stock >= $item->quantity){

                } else {
                    $product_quantity_status = 1;
                }
            }

            if($product_quantity_status == 1){

                return redirect()->route('web.view_cart')->with('msg', 'product quantity not available for some item.');
            }

            if ($request->input('payment_type') == 1) {

                if (empty($request->file('doc')) && empty($request->input('facebook_link'))) {
                    return redirect()->back()->with('message', 'Please upload the required data');
                } else {
                    $request->validate([
                        'address_id' => 'required',
                        'payment_type' => 'required',
                    ],
                    [   'address_id.required' => 'Select Billing Address',
                        'payment_type.required' => 'Select Payment Type',
                    ]);
                }
            } else{

                $request->validate([
                    'address_id' => 'required',
                    'payment_type' => 'required'
                ],
                [   'address_id.required' => 'Select Billing Address',
                    'payment_type.required' => 'Select Payment Type',
                ]);
            }

            $user_name = Auth::guard('users')->user()->name;
            $user_email = Auth::guard('users')->user()->email;
            $user_contact_no = Auth::guard('users')->user()->contact_no;

            $cart_data = [];
            $user_id = Auth::guard('users')->user()->id;
            $shipping_amount = 0;
            $total_quantity = 0;
            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
                    if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                        $product = DB::table('product')
                            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                            ->where('product_type_price.type', $cart[$i]->product_type)
                            ->where('product.id', $cart[$i]->product_id)
                            ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                            ->distinct()
                            ->first();

                        $shipping_amount = $shipping_amount + ($product->shipping_amount * $cart[$i]->quantity);

                        $cart_data[] = [
                            'product_id' => $cart[$i]->product_id,
                            'product_id' => $product->id,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount
                        ];
                    } 

                    if($cart[$i]->product_type == 3) {

                        $product = DB::table('cart')
                            ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                            ->where('cart.product_id', $cart[$i]->product_id)
                            ->where('cart.product_type', 3)
                            ->select('product.*')
                            ->distinct()
                            ->first();

                        $shipping_amount = $shipping_amount + (($product->shipping_amount * $product->weight) * $cart[$i]->quantity);

                        $cart_data[] = [
                            'product_id' => $cart[$i]->product_id,
                            'product_id' => $product->id,
                            'price' => $product->customer_price,
                            'seller_price' => $product->distributor_price,
                            'quantity' => $cart[$i]->quantity,
                            'discount' => $product->discount
                        ];
                    } 

                    $total_quantity =  $total_quantity + $cart[$i]->quantity;
                }
            } else {
                return redirect()->route('web.index');
            }

            /** Cart Quantity **/
            $cart_quantity_set = DB::table('cart_quantity_for_seller')
                ->first();

            if(Auth::guard('users')->user()->user_role == 2){

                // $check_cart_product_quantity = 0;
                // for ($i = 0; $i < count($cart); $i++) {

                //     if($cart[$i]->quantity >= $cart_quantity_set->qty){
                //         $check_cart_product_quantity = 1;
                //     }
                // }
                
                if ((count($cart) >= $cart_quantity_set->qty) || ($total_quantity >= $cart_quantity_set->qty)) {
                    $total = 0;
                    foreach ($cart_data as $key => $item) {

                        if (!empty($item['discount'])) {
                            $discount = ($item['seller_price']*$item['discount']) / 100;
                            $selling_price = $item['seller_price'] - $discount;
                        } else {
                            $selling_price = $item['seller_price'];
                        }

                        $total_amount = ($selling_price * $item['quantity']);

                        $total = $total_amount + $total;
                    }
                } else {
                    $total = 0;
                    foreach ($cart_data as $key => $item) {

                        if (!empty($item['discount'])) {
                            $discount = ($item['price']*$item['discount']) / 100;
                            $selling_price = $item['price'] - $discount;
                        } else {
                            $selling_price = $item['price'];
                        }

                        $total_amount = ($selling_price * $item['quantity']);

                        $total = $total_amount + $total;
                    }
                }
            } else {
                $total = 0;
                foreach ($cart_data as $key => $item) {

                    if (!empty($item['discount'])) {
                        $discount = ($item['price']*$item['discount']) / 100;
                        $selling_price = $item['price'] - $discount;
                    } else {
                        $selling_price = $item['price'];
                    }

                    $total_amount = ($selling_price * $item['quantity']);

                    $total = $total_amount + $total;
                }
            }

            $delivery_amount = ($total * 10)/100;

            if ($request->input('payment_type') == 1) {

                DB::table('order')
                    ->insert([
                        'order_id' => '#'.time(),
                        'user_id' => $user_id,
                        'address_id' => $request->input('address_id'),
                        'amount' => $total,
                        'delivery_amount' => $delivery_amount,
                        'payment_type' => 1,
                        'shipping_amount' => $shipping_amount,
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);

                $order_id = DB::getPdo()->lastInsertId();

                if (!empty($request->input('coupon_status_1'))) {

                    $coupon_data = DB::table('coupon')
                        ->where('coupon_code', $request->input('coupon'))
                        ->first();
                    
                    DB::table('coupon_user')
                        ->insert([
                            'order_id' => $order_id,
                            'coupon_id' => $coupon_data->id,
                            'user_id' => $user_id,
                            'coupon_amount' => $coupon_data->coupon_amount,
                        ]);
                }

                if ($request->hasFile('doc')) {

                    for ($i=0; $i < count($request->file('doc')); $i++) { 
                        
                        $doc = $request->file('doc')[$i];
                        $file   = time().$i.'.'.$doc->getClientOriginalExtension();

                        $destinationPath = public_path('/assets/doc');
                        $img = Image::make($doc->getRealPath());
                        $img->save($destinationPath.'/'.$file);

                        DB::table('orde_file')
                            ->insert([
                                'order_id' => $order_id,
                                'file' => $file
                            ]);
                    }
                }

                if ($request->has('facebook_link')) {
                    
                     DB::table('order')
                        ->where('id', $order_id)
                        ->update([
                            'facebook_link' => $request->input('facebook_link')
                        ]);
                }

                if (count($cart) > 0) {
                    if(Auth::guard('users')->user()->user_role == 2) {

                        // $check_cart_product_quantity = 0;
                        // for ($i = 0; $i < count($cart); $i++) {

                        //     if($cart[$i]->quantity >= $cart_quantity_set->qty){
                        //         $check_cart_product_quantity = 1;
                        //     }
                        // }

                        if ((count($cart) >= $cart_quantity_set->qty) || ($total_quantity >= $cart_quantity_set->qty)) {
                            
                            for ($i = 0; $i < count($cart); $i++) {
                                if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                    $product = DB::table('product')
                                        ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                        ->where('product_type_price.type', $cart[$i]->product_type)
                                        ->where('product.id', $cart[$i]->product_id)
                                        ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                        ->distinct()
                                        ->first();

                                    DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->distributor_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 

                                if($cart[$i]->product_type == 3) {

                                    $product = DB::table('cart')
                                        ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                        ->where('cart.product_id', $cart[$i]->product_id)
                                        ->where('cart.product_type', 3)
                                        ->select('product.*')
                                        ->distinct()
                                        ->first();

                                     DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->distributor_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 
                            }
                        } else {
                            for ($i = 0; $i < count($cart); $i++) {
                                if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                    $product = DB::table('product')
                                        ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                        ->where('product_type_price.type', $cart[$i]->product_type)
                                        ->where('product.id', $cart[$i]->product_id)
                                        ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                        ->distinct()
                                        ->first();

                                    DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->customer_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 

                                if($cart[$i]->product_type == 3) {

                                    $product = DB::table('cart')
                                        ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                        ->where('cart.product_id', $cart[$i]->product_id)
                                        ->where('cart.product_type', 3)
                                        ->select('product.*')
                                        ->distinct()
                                        ->first();

                                    DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->customer_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 
                            }
                        }
                    } else {

                        for ($i = 0; $i < count($cart); $i++) {
                                if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                    $product = DB::table('product')
                                        ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                        ->where('product_type_price.type', $cart[$i]->product_type)
                                        ->where('product.id', $cart[$i]->product_id)
                                        ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                        ->distinct()
                                        ->first();

                                    DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->customer_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 

                                if($cart[$i]->product_type == 3) {

                                    $product = DB::table('cart')
                                        ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                        ->where('cart.product_id', $cart[$i]->product_id)
                                        ->where('cart.product_type', 3)
                                        ->select('product.*')
                                        ->distinct()
                                        ->first();

                                    DB::table('order_detail')
                                        ->insert([
                                            'order_id' => $order_id,
                                            'product_id' => $product->id,
                                            'product_type' => $cart[$i]->product_type,
                                            'price' => $product->customer_price,
                                            'discount' => $product->discount,
                                            'quantity' => $cart[$i]->quantity,
                                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                        ]);
                                } 
                        }
                    }
                }

                /** Dcrementing Stock **/
                if (count($cart) > 0) {
                    for ($i = 0; $i < count($cart); $i++) {
                        DB::table('product')
                            ->where('id', $cart[$i]->product_id)
                            ->decrement('stock', $cart[$i]->quantity);
                    }
                }

                DB::table('cart')
                    ->where('user_id', $user_id)
                    ->delete();

                /** Sending Order Email **/

                $order_detail = DB::table('order_detail')
                    ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                    ->where('order_detail.product_type', 1)
                    ->where('order_detail.order_id', $order_id)
                    ->select('order_detail.*', 'product.product_name')
                    ->get();

                $data = [];

                if (!empty($order_detail) && (count($order_detail) > 0)) {

                    foreach ($order_detail as $key => $item) {
                        $data [] = [
                            'product_id' => $item->product_id,
                            'product_name' => $item->product_name,
                            'quantity' => $item->quantity,
                            'rate' => $item->price,
                            'discount' => $item->discount
                        ];
                    }
                }

                $order_detail = DB::table('order_detail')
                        ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                        ->where('order_detail.product_type', 2)
                        ->where('order_detail.order_id', $order_id)
                        ->select('order_detail.*', 'product.product_name')
                        ->get();

                if (!empty($order_detail) && (count($order_detail) > 0)){

                    foreach ($order_detail as $key => $item) {
                        $data [] = [
                            'product_id' => $item->product_id,
                            'product_name' => $item->product_name,
                            'quantity' => $item->quantity,
                            'rate' => $item->price,
                            'discount' => $item->discount
                        ];
                    }
                }

                $order_detail = DB::table('order_detail')
                        ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                        ->where('order_detail.product_type', 3)
                        ->where('order_detail.order_id', $order_id)
                        ->select('order_detail.*', 'product.product_name')
                        ->get();

                if (!empty($order_detail) && (count($order_detail) > 0)){

                    foreach ($order_detail as $key => $item) {
                        $data [] = [
                            'product_id' => $item->product_id,
                            'product_name' => $item->product_name,
                            'quantity' => $item->quantity,
                            'rate' => $item->price,
                            'discount' => $item->discount
                        ];
                    }
                }

                $request_info = "<table width=\"100%\">
                    <tr>
                        <td>
                            <address>
                                <strong>Billed to</strong>
                                <br>".$user_name."
                                <br>Phone: ".$user_contact_no."
                                <br>Email: ".$user_email."
                            </address>
                        </td>
                        <td>
                            <address>
                                <strong>Assam Products</strong>
                                <br>Guwahati, Assam
                                <br>Phone: 88638746953
                                <br>Email: info@assamproducts.com
                             </address>
                        </td>
                    </tr>
                </table><br>
                <table border=\"1\" class=\"table\">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Sub-Total</th>
                    </tr>";

                foreach ($data as $key => $item) {

                    $sub_total = $item['quantity'] * $item['rate'];

                    if (!empty($item['discount'])) {
                        $discount = ($item['rate'] * $item['discount']) / 100;
                        $selling_price = $item['rate'] - $discount;

                        $sub_total = $item['quantity'] * $selling_price;
                    }

                    $request_info = $request_info."<tr>
                        <td>".$item['product_name']."</td>
                        <td>".$item['quantity']."</td>
                        <td>".$item['rate']."</td>
                        <td>".$item['discount']."</td>
                        <td>".$sub_total."</td>
                    </tr>";
                }

                "</table>
                <p style=\"text-align: left;\">Date : ".date('d-m-Y')."</p>";

                $request_info = $request_info."<br><br>";

                
                $subject = "Eagle Group Order Confirmation";

                $data_1 = [
                    'message' => $request_info,
                    'subject' => $subject,
                ];

                Mail::to($user_email)->send(new OrderEmail($data_1));

                sendSMS($user_contact_no, "Your order has been placed successfully");

                return view('web.checkout.order-confirmed');

            } else {

                DB::table('order')
                    ->insert([
                        'order_id' => '#'.time(),
                        'user_id' => $user_id,
                        'address_id' => $request->input('address_id'),
                        'amount' => $total,
                        'payment_type' => 2,
                        'payment_status' => 1,
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);

                $order_id = DB::getPdo()->lastInsertId();

                if (!empty($request->input('coupon_status_1'))) {

                    $coupon_data = DB::table('coupon')
                        ->where('coupon_code', $request->input('coupon'))
                        ->first();
                    
                    DB::table('coupon_user')
                        ->insert([
                            'order_id' => $order_id,
                            'coupon_id' => $coupon_data->id,
                            'user_id' => $user_id,
                            'coupon_amount' => $coupon_data->coupon_amount,
                        ]);

                    $coupon_discount = ($total * $coupon_data->coupon_amount) / 100;
                    $total = $total - $coupon_discount;
                }

                $api = new \Instamojo\Instamojo(
                    config('services.instamojo.api_key'),
                    config('services.instamojo.auth_token'),
                    config('services.instamojo.url')
                );    

                try {
                    $response = $api->paymentRequestCreate(array(
                        "purpose" => "Payment",
                        "amount" => $total,
                        "buyer_name" => $user_name,
                        "send_email" => true,
                        "email" => $user_email,
                        "phone" => $user_contact_no,
                        "redirect_url" => "http://assamproducts.webinfotechghy.xyz/".$order_id
                    ));
            
                    DB::table('order')
                        ->where('id', $order_id)
                        ->update([
                            'payment_request_id' => $response['id'],
                            'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                        ]);
                            
                    header('Location: ' . $response['longurl']);
                    exit();
                }catch (Exception $e) {
                    print('Error: ' . $e->getMessage());
                }
            }
        }
    }

    public function thankyou()
    {
        return view('web.checkout.order-confirmed');
    }

    public function paySuccess($order_id)
    {
        try {
    
            $api = new \Instamojo\Instamojo(
                config('services.instamojo.api_key'),
                config('services.instamojo.auth_token'),
                config('services.instamojo.url')
            );
     
            $response = $api->paymentRequestStatus(request('payment_request_id'));
     
            if( !isset($response['payments'][0]['status']) ) {
                return redirect('web.checkout');
            } else if($response['payments'][0]['status'] != 'Credit') {
                return redirect('web.checkout');
            } 
        }catch (\Exception $e) {
            return redirect('web.checkout');
        }
        
        if($response['payments'][0]['status'] == 'Credit') {
 
            $user_id = Auth::guard('users')->user()->id;
            $user_name = Auth::guard('users')->user()->name;
            $user_email = Auth::guard('users')->user()->email;
            $user_contact_no = Auth::guard('users')->user()->contact_no;
            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            DB::table('order')
                ->where('id', $order_id)
                ->where('user_id', $user_id)
                ->where('payment_request_id', $response['id'])
                ->update(['payment_id' => $response['payments'][0]['payment_id'], 'payment_status' => '2']);

            /** Cart Quantity **/
            $cart_quantity_set = DB::table('cart_quantity_for_seller')
                ->first();

            $total_quantity = 0;
            $cart = DB::table('cart')->where('user_id', $user_id)->get();
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
        
                    $total_quantity =  $total_quantity + $cart[$i]->quantity;
                }
            } else {
                return redirect()->route('web.index');
            }

            if (count($cart) > 0) {
                if(Auth::guard('users')->user()->user_role == 2) {

                    // $check_cart_product_quantity = 0;
                    // for ($i = 0; $i < count($cart); $i++) {

                    //     if($cart[$i]->quantity >= $cart_quantity_set->qty){
                    //         $check_cart_product_quantity = 1;
                    //     }
                    // }

                    if ((count($cart) >= $cart_quantity_set->qty) || ($total_quantity >= $cart_quantity_set->qty)) {
                        
                        for ($i = 0; $i < count($cart); $i++) {
                            if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                $product = DB::table('product')
                                    ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                    ->where('product_type_price.type', $cart[$i]->product_type)
                                    ->where('product.id', $cart[$i]->product_id)
                                    ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                    ->distinct()
                                    ->first();

                                DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->distributor_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 

                            if($cart[$i]->product_type == 3) {

                                $product = DB::table('cart')
                                    ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                    ->where('cart.product_id', $cart[$i]->product_id)
                                    ->where('cart.product_type', 3)
                                    ->select('product.*')
                                    ->distinct()
                                    ->first();

                                 DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->distributor_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 
                        }
                    } else {
                        for ($i = 0; $i < count($cart); $i++) {
                            if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                $product = DB::table('product')
                                    ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                    ->where('product_type_price.type', $cart[$i]->product_type)
                                    ->where('product.id', $cart[$i]->product_id)
                                    ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                    ->distinct()
                                    ->first();

                                DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->customer_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 

                            if($cart[$i]->product_type == 3) {

                                $product = DB::table('cart')
                                    ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                    ->where('cart.product_id', $cart[$i]->product_id)
                                    ->where('cart.product_type', 3)
                                    ->select('product.*')
                                    ->distinct()
                                    ->first();

                                DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->customer_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 
                        }
                    }
                } else {

                    for ($i = 0; $i < count($cart); $i++) {
                            if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                                $product = DB::table('product')
                                    ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                                    ->where('product_type_price.type', $cart[$i]->product_type)
                                    ->where('product.id', $cart[$i]->product_id)
                                    ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                                    ->distinct()
                                    ->first();

                                DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->customer_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 

                            if($cart[$i]->product_type == 3) {

                                $product = DB::table('cart')
                                    ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                                    ->where('cart.product_id', $cart[$i]->product_id)
                                    ->where('cart.product_type', 3)
                                    ->select('product.*')
                                    ->distinct()
                                    ->first();

                                DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order_id,
                                        'product_id' => $product->id,
                                        'product_type' => $cart[$i]->product_type,
                                        'price' => $product->customer_price,
                                        'discount' => $product->discount,
                                        'quantity' => $cart[$i]->quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            } 
                    }
                }
            }

            /** Dcrementing Stock **/
            if (count($cart) > 0) {
                for ($i = 0; $i < count($cart); $i++) {
                    DB::table('product')
                        ->where('id', $cart[$i]->product_id)
                        ->decrement('stock', $cart[$i]->quantity);
                }
            }

            DB::table('cart')
                ->where('user_id', $user_id)
                ->delete();

            /** Sending Order Email **/

            $order_detail = DB::table('order_detail')
                ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                ->where('order_detail.product_type', 1)
                ->where('order_detail.order_id', $order_id)
                ->select('order_detail.*', 'product.product_name')
                ->get();

            $data = [];

            if (!empty($order_detail) && (count($order_detail) > 0)) {

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount,
                    ];
                }
            }

            $order_detail = DB::table('order_detail')
                    ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                    ->where('order_detail.product_type', 2)
                    ->where('order_detail.order_id', $order_id)
                    ->select('order_detail.*', 'product.product_name')
                    ->get();

            if (!empty($order_detail) && (count($order_detail) > 0)){

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount
                    ];
                }
            }

            $order_detail = DB::table('order_detail')
                    ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                    ->where('order_detail.product_type', 3)
                    ->where('order_detail.order_id', $order_id)
                    ->select('order_detail.*', 'product.product_name')
                    ->get();

            if (!empty($order_detail) && (count($order_detail) > 0)){

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount
                    ];
                }
            }

            $request_info = "<table width=\"100%\">
                <tr>
                    <td>
                        <address>
                            <strong>Billed to</strong>
                            <br>".$user_name."
                            <br>Phone: ".$user_contact_no."
                            <br>Email: ".$user_email."
                        </address>
                    </td>
                    <td>
                        <address>
                            <strong>Assam Products</strong>
                            <br>Guwahati, Assam
                            <br>Phone: 88638746953
                            <br>Email: info@assamproducts.com
                         </address>
                    </td>
                </tr>
            </table><br>
            <table border=\"1\" class=\"table\">
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Sub-Total</th>
                </tr>";

            foreach ($data as $key => $item) {

                $sub_total = $item['quantity'] * $item['rate'];

                if (!empty($item['discount'])) {
                    $discount = ($item['rate'] * $item['discount']) / 100;
                    $selling_price = $item['rate'] - $discount;

                    $sub_total = $item['quantity'] * $selling_price;
                }

                $request_info = $request_info."<tr>
                    <td>".$item['product_name']."</td>
                    <td>".$item['quantity']."</td>
                    <td>".$item['rate']."</td>
                    <td>".$item['discount']."</td>
                    <td>".$sub_total."</td>
                </tr>";
            }
            "</table>
            <p style=\"text-align: left;\">Date : ".date('d-m-Y')."</p>";

            $request_info = $request_info."<br><br>";
            
            
            $subject = "Eagle Group Order Confirmation";

            $data_1 = [
                'message' => $request_info,
                'subject' => $subject,
            ];

            Mail::to($user_email)->send(new OrderEmail($data_1));

            sendSMS($user_contact_no, "Your order has been placed successfully");
 
            return view('web.checkout.order-confirmed');
        } 
    }
}
