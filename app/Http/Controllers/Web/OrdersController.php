<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use DB;

class OrdersController extends Controller
{
    public function orderHistory(Request $request)
    {
        $orders = DB::table('order')
        	->where('order.user_id', Auth()->user()->id)
            ->leftJoin('coupon_user', 'order.id', '=', 'coupon_user.order_id')
        	->orderBy('order.id', 'DESC')
            ->select('order.*', 'coupon_user.coupon_amount')
        	->get();

        $order_history = [];
        foreach ($orders as $key => $item) {

            $payment = $item->amount;
            $order_id = $item->id;
            $order_id_1 = $item->order_id;
            $coupon_amount = $item->coupon_amount;
            $created_at = $item->created_at;
            $shipping_amount = $item->shipping_amount;
            $billing_address = DB::table('address')
                ->where('id', $item->address_id)
                ->first();

        	if($item->payment_status == 1)
        		$payment_status = "Failed";
        	else
        		$payment_status = "Paid";

        	if($item->order_status == 1)
        		$order_status = "New Order";
        	else if($item->order_status == 2)
        		$order_status = "Order Accepted";

        	$order_detail = DB::table('order_detail')
                ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                ->where('order_detail.product_type', 1)
                ->where('order_detail.order_id', $order_id)
                ->select('order_detail.*', 'product.product_name', 'product.banner', 'product.slug', 'product.deleted_at')
                ->get();

            $data = [];

            if (!empty($order_detail) && (count($order_detail) > 0)) {

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'banner' => $item->banner,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount,
                        'product_type' => $item->product_type,
                        'deleted_at' => $item->deleted_at,
                        'slug' => $item->slug
                    ];
                }
            }

            $order_detail = DB::table('order_detail')
                    ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                    ->where('order_detail.product_type', 2)
                    ->where('order_detail.order_id', $order_id)
                    ->select('order_detail.*', 'product.product_name', 'product.banner', 'product.slug', 'product.deleted_at')
                    ->get();

            if (!empty($order_detail) && (count($order_detail) > 0)){

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'banner' => $item->banner,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount,
                        'product_type' => $item->product_type,
                        'deleted_at' => $item->deleted_at,
                        'slug' => $item->slug
                    ];
                }
            }

            $order_detail = DB::table('order_detail')
                    ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                    ->where('order_detail.product_type', 3)
                    ->where('order_detail.order_id', $order_id)
                    ->select('order_detail.*', 'product.product_name' , 'product.banner', 'product.slug', 'product.deleted_at')
                    ->get();

            if (!empty($order_detail) && (count($order_detail) > 0)){

                foreach ($order_detail as $key => $item) {
                    $data [] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'banner' => $item->banner,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount,
                        'product_type' => $item->product_type,
                        'deleted_at' => $item->deleted_at,
                        'slug' => $item->slug
                    ];
                }
            }

        	$order_history [] = [
        		'id' => $order_id,
        		'order_id' => $order_id_1,
                'amount' => $payment,
                'shipping_amount' => $shipping_amount,
        		'payment_status' => $payment_status,
        		'order_status' => $order_status,
        		'order_date' => \Carbon\Carbon::parse($created_at)->toDayDateTimeString(),
                'coupon_amount' => $coupon_amount,
        		'order_detail' => $data,
        		'billing_address' => $billing_address
            ];
        }

        return view('web.orders.order_history', ['order_history' => $order_history]);
    }
}
