<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class IndexController extends Controller
{
    public function index()
    {
        /** Feature Product **/
        $feature_product_record = [];
        $first_category_product_record = [];

        $first_category_product = DB::table('product')
            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->where('product.product_type', 1)
            ->where('product.feature_product', 1)
            ->where('product_type_price.type', 2)
            ->where('product.status', 1)
            ->select('product.*', 'product_type_price.customer_price as u_customer_price', 'product_type_price.distributor_price as u_distributor_price')
            ->get();

        foreach ($first_category_product as $key => $item){
            $url = asset('assets/product/banner/'.$item->banner);

            $first_category_product_record [] = [
                'id' => $item->id,
                'slug' => $item->slug,
                'product_name' => $item->product_name,
                'price' => $item->u_customer_price,
                'seller_price' => $item->u_distributor_price,
                'discount' => $item->discount,
                'url' => $url,
                'product_type' => $item->product_type
            ];
        }

        $first_category_product = DB::table('product')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->where('product.product_type', 2)
            ->where('product.feature_product', 1)
            ->where('product.status', 1)
            ->select('product.*')
            ->get();
            
        foreach ($first_category_product as $key => $item){
            $url = asset('assets/product/banner/'.$item->banner);

            $first_category_product_record [] = [
                'id' => $item->id,
                'slug' => $item->slug,
                'product_name' => $item->product_name,
                'price' => $item->customer_price,
                'seller_price' => $item->distributor_price,
                'discount' => $item->discount,
                'url' => $url,
                'product_type' => $item->product_type
            ];
        }

        $sliders = DB::table('sliders')->get();

        /** Coupons **/
        $coupon = DB::table('coupon');

        if(Auth::guard('users')->user()) {

            if((Auth::user()->user_role == 2) && !empty(Auth::user())){

                $coupon = $coupon
                    ->where('user_type', 2)
                    ->where('status', 1);
            } else {
    
                $coupon = $coupon
                    ->where('user_type', 1)
                    ->where('status', 1);
            }
        }

        $coupon = $coupon
            ->where('status', 1)
            ->get();

        if (!empty($coupon) && (count($coupon) > 0))
            $coupon = $coupon;
        else
            $coupon = 0;

        $index_data = DB::table('header_section')
            ->first();

        return view('web.index', ['feature_product_record' => $first_category_product_record, 'sliders' => $sliders, 'coupon' => $coupon, 'index_data' => $index_data]);
    }
}
