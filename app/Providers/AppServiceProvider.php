<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use Session;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('web.include.header', function ($view) {

            $header_color = DB::table('header_section')
                ->first();

            $top_category = DB::table('top_category')
                ->where('status', 1)
                ->get();

            $categories = [];
            foreach ($top_category as $key => $item) {
                
                $sub_categories = DB::table('sub_category')
                    ->where('top_category_id', $item->id)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')
                    ->get();

                $categories[] = [
                    'top_category_id' => $item->id,
                    'top_cate_name' => $item->top_cate_name,
                    'sub_categories' => $sub_categories
                ];
            }

            /** Cart Items **/
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

                        $product = DB::table('product')
                            ->where('product.id', $cart[$i]->product_id)
                            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                            ->where('product_type_price.type', $cart[$i]->product_type)
                            ->where('product.status', 1)
                            ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
                            ->distinct()
                            ->first();

                        $type = "";
                        if(($cart[$i]->product_type == 1) || ($cart[$i]->product_type == 2)) {

                            if ($cart[$i]->product_type == 1)
                                $type = "Ready Made";
                            else
                                $type = "Raw";

                            $cart_data[] = [
                                'product_id' => $product->id,
                                'product_name' => $product->product_name,
                                'price' => $product->customer_price,
                                'seller_price' => $product->distributor_price,
                                'quantity' => $cart[$i]->quantity,
                                'discount' => $product->discount,
                                'product_type' => $type
                            ];
                        }

                        $product = DB::table('cart')
                            ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                            ->where('cart.product_id', $cart[$i]->product_id)
                            ->where('product.status', 1)
                            ->where('cart.product_type', 3)
                            ->select('product.*')
                            ->distinct()
                            ->first();

                        if($cart[$i]->product_type == 3) {

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
                                        $type = "Ready Made";
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

            $data = [
                'categories' => $categories,
                'cart_data' => $cart_data,
                'header_color' => $header_color
            ];
           
            $view->with('header_data', $data);
        });

        View::composer('web.include.footer', function ($view) {

            $footer = DB::table('header_section')
                ->first();

            $data = [
                'footer' => $footer
            ];
           
            $view->with('footer_data', $data);
        });

        View::composer('admin.template.partials.header', function ($view) {

            $new_order_cnt = DB::table('order')
                ->where('order_status', 1)
                ->count();

            $new_seller_cnt = DB::table('users')
                ->where('user_role', 2)
                ->where('verification', 1)
                ->count();

            $data = [
                'new_order_cnt' => $new_order_cnt,
                'new_seller_cnt' => $new_seller_cnt,
            ];
           
            $view->with('header_data', $data);
        });
    }
}
