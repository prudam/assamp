<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Response;
use Auth;

class ProductController extends Controller
{
    public function productDetail($slug, $product_id) 
    {
        /** Product Details **/
        $product_detail = DB::table('product')
            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->where('product.id', $product_id)
            ->where('product_type_price.type', 2)
            ->where('product.deleted_at', NULL)
            ->select('product.*', 'product_type_price.customer_price', 'product_type_price.distributor_price')
            ->first();
            
        /** Top-Category and Sub-Category Detail **/
        $top_sub_category_detail = DB::table('sub_category')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->where('sub_category.id', $product_detail->sub_category_id)
            ->select('sub_category.*', 'top_category.top_cate_name')
            ->get();

        /** Sub-Category according to Top-Category **/
        $sub_categories = DB::table('sub_category')
            ->where('sub_category.top_category_id', $top_sub_category_detail[0]->top_category_id)
            ->get();

        $data = [];
        foreach ($sub_categories as $key => $item) {
            $count = DB::table('product')
                ->where('sub_category_id', $item->id)
                ->count();

            $data[] = [
                'id' => $item->id,
                'top_category_id' => $item->top_category_id,
                'sub_cate_name' => $item->sub_cate_name,
                'total_products' => $count
            ];
        }

        /** Product Slider Images **/
        $product_slider_images = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();

        // /** Product Colors **/
        // $product_colors = DB::table('product_color_mapping')
        //     ->leftJoin('color', 'product_color_mapping.color_id', '=', 'color.id')
        //     ->where('product_color_mapping.product_id', $product_id)
        //     ->select('product_color_mapping.*', 'color.color', 'color.color_code')
        //     ->get();

        /** Related Product **/
        // $related_product_record = DB::table('product')
        //     ->where('sub_category_id', $product_detail->sub_category_id)
        //     ->orderBy('id', 'DESC')
        //     ->limit(10)
        //     ->get();

        $related_product_record = DB::table('product')
            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->where('product_type_price.type', 2)
            ->where('product.deleted_at', NULL)
            ->where('product.sub_category_id', $product_detail->sub_category_id)
            ->select('product.id', 'product.banner', 'product.slug', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product_type_price.customer_price', 'product_type_price.distributor_price')
            ->groupBy('product.id', 'product.banner', 'product.slug', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product_type_price.customer_price', 'product_type_price.distributor_price')
            ->orderBy('product.id', 'DESC')
            ->limit(10)
            ->get();

        $related_record = [];
        foreach ($related_product_record as $key => $item){

            $related_record [] = [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'banner' => $item->banner,
                'discount' => $item->discount,
                'customer_price' => $item->customer_price,
                'distributor_price' => $item->distributor_price,
                'slug' => $item->slug,
            ];
        }

        // /** Reviews **/
        // $reviews = DB::table('review')
        //     ->leftJoin('users', 'review.user_id', '=', 'users.id')
        //     ->where('product_id', $product_id)
        //     ->where('review.status', 1)
        //     ->select('review.product_id', 'review.star', 'review.comment', 'users.name', 'review.created_at')
        //     ->orderBy('review.created_at', 'DESC')
        //     ->get();

        return view('web.product.product_detail', ['product_detail' => $product_detail, 'top_sub_category_detail' => $top_sub_category_detail, 'product_slider_images' => $product_slider_images, 'sub_categories' => $data, 'related_record' => $related_record]);
    }

    public function bellBrassProductDetail($slug, $product_id) 
    {
        /** Product Details **/
        $product_detail = DB::table('product')
            ->where('id', $product_id)
            ->where('product.deleted_at', NULL)
            ->first();

        /** Product Slider Images **/
        $product_slider_images = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();
        
        return view('web.product.metal.product_detail', ['product_detail' => $product_detail, 'product_slider_images' => $product_slider_images]);
    }

    public function bannerImage ($product_id) 
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->get();

        $path = public_path('assets/product/banner/'.$product_record[0]->banner);

        if (!File::exists($path)) 
            $response = 404;

        $file     = File::get($path);
        $type     = File::extension($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function metalBannerImage ($product_id) 
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        $path = public_path('assets/product/banner/'.$product_record->banner);

        if (!File::exists($path)) 
            $response = 404;

        $file     = File::get($path);
        $type     = File::extension($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function productAdditionalImage ($product_additional_img_id) 
    {
        try {
            $product_additional_img_id = decrypt($product_additional_img_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $product_additional_record = DB::table('product_additional_images')
            ->where('id', $product_additional_img_id)
            ->get();

        $path = public_path('assets/product/images/'.$product_additional_record[0]->additional_image);

        if (!File::exists($path)) 
            $response = 404;

        $file     = File::get($path);
        $type     = File::extension($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function productSearch ($keyword)
    {
        $search_key = $keyword;
        $keyword = ucfirst($keyword);
        $keyword = explode(" ", $keyword);

        $product_list = "";
        $products = DB::table('product')
            ->join('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->where('product.product_type', 1)
            ->Where('product.product_name', 'like',  '%'.$search_key.'%');

        $products = $products
            ->where('product_type_price.type', 2)
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->select('product.product_name', 'product.slug', 'product.banner', 'product.id', 'product.banner', 'product_type_price.customer_price', 'product_type_price.distributor_price', 'product_type_price.type')
            ->distinct('product.product_name');
        
        if( $products->count() > 0){
            $products = $products->limit(20)->get();
        }else{
            $products = DB::table('product')
                ->join('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                ->where('product.product_type', 1)
                ->Where(function ($query) use($keyword) {
    
                    for ($i = 0; $i < count($keyword); $i++){
                        $query->orWhere('product.product_name', 'like',  '%'.$keyword[$i].'%');
                    }      
                });
    
            $products = $products
                ->where('product_type_price.type', 2)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.product_name', 'product.slug', 'product.banner', 'product.id', 'product.banner', 'product_type_price.customer_price', 'product_type_price.distributor_price', 'product_type_price.type')
                ->distinct('product.product_name')
                ->limit(20)
                ->get();
        }
        if (!empty($products)) {

            foreach ($products as $key => $item) {

                $url = asset('assets/product/banner/'.$item->banner);

                if (Auth::check()){

                    if(Auth::guard('users')->user()->user_role == 2)
                        $price = $item->distributor_price;
                    else
                        $price = $item->customer_price; 
                } else
                    $price = $item->customer_price; 
    
                $product_list = $product_list."<div class=\"row\"><span class=\"triup glyphicon glyphicon-triangle-top\"></span></div> <div class=\"row livesrc\"><div class=\"col-md-3\"><img src=\"".$url."\" width=\"100\"></div><div class=\"col-md-9\"><p style=\"font-weight: bold;\"><a href=\"".route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id])."\">".$item->product_name."</a></p><p>₹".$price."</p></div></div>";
            }
        } 

        $products = DB::table('product')
            ->where('product.product_type', 2)
            ->Where(function ($query) use($keyword) {

                for ($i = 0; $i < count($keyword); $i++){
                    $query->orWhere('product.product_name', 'like',  '%'.$keyword[$i].'%');
                }      
            });

        $products = $products
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->select('product.*')
            ->distinct('product.product_name')
            ->get();

        if (!empty($products)) {

            foreach ($products as $key => $item) {

                $url = asset('assets/product/banner/'.$item->banner);
    
                if (Auth::check()){

                    if(Auth::guard('users')->user()->user_role == 2)
                        $price = $item->distributor_price;
                    else
                        $price = $item->customer_price; 
                } else
                    $price = $item->customer_price; 
    
                $product_list = $product_list."<div class=\"row\"><span class=\"triup glyphicon glyphicon-triangle-top\"></span></div> <div class=\"row livesrc\"><div class=\"col-md-3\"><img src=\"".$url."\" width=\"100\"></div><div class=\"col-md-9\"><p style=\"font-weight: bold;\"><a href=\"".route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id])."\">".$item->product_name."</a></p><p>₹".$price."</p></div></div>";
            }
        }
        
        if(!empty($product_list))
            print $product_list;  
        else {
            $product_list = "";
            
            print $product_list;
        }
    }

    public function productSearchSubmit($keyword,Request $request)
    {


        $search_key = $keyword;
        $keyword = ucfirst($keyword);
        $keyword = explode(" ", $keyword);

        $product_list = "";
        $products = DB::table('product')
            ->join('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->where('product.product_type', 1)
            ->Where('product.product_name', 'like',  '%'.$search_key.'%');

        $products = $products
            ->where('product_type_price.type', 2)
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL)
            ->select('product.product_name', 'product.slug', 'product.banner', 'product.id', 'product.banner', 'product_type_price.customer_price', 'product_type_price.distributor_price', 'product_type_price.type')
            ->distinct('product.product_name');
        
        if( $products->count() > 0){
            
            $products = $products->paginate(20);
        }else{
            $products = DB::table('product')
                ->join('product_type_price', 'product.id', '=', 'product_type_price.product_id')
                ->where('product.product_type', 1)
                ->Where(function ($query) use($keyword) {
    
                    for ($i = 0; $i < count($keyword); $i++){
                        $query->orWhere('product.product_name', 'like',  '%'.$keyword[$i].'%');
                    }      
                });
    
            $products = $products
                ->where('product_type_price.type', 2)
                ->where('product.status', 1)
                ->where('product.deleted_at', NULL)
                ->select('product.product_name', 'product.slug', 'product.banner', 'product.id', 'product.banner', 'product_type_price.customer_price', 'product_type_price.distributor_price', 'product_type_price.type')
                ->distinct('product.product_name')
                ->paginate(20);
        }

        if ($request->ajax()) {
            return view('web.product.ajax.presult', compact('products'));
        }

        // $sub_category_record = DB::table('sub_category')
        //         ->where('id', $sub_category_id)
        //         ->where('status', 1)
        //         ->first();

        $top_category_record = DB::table('top_category')
            ->where('status', 1)
            ->paginate(20);

        $top_sub_category = [];
        foreach ($top_category_record as $key => $item) {
            
            $sub_category_records = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->select('sub_category.id', 'sub_category.sub_cate_name', 'sub_category.slug')
                ->get();

            $top_sub_category [] = [
                'id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'slug' => $item->slug,
                'sub_category' => $sub_category_records
            ];
        }

        return view('web.product.product_list', compact('products', 'sub_category_record', 'top_sub_category'));
    }

    public function productList(Request $request, $slug, $sub_category_id, $sort_by)
    {
        $products = DB::table('product')
            ->leftJoin('product_type_price', 'product.id', '=', 'product_type_price.product_id')
            ->where('product_type_price.type', 2)
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL);

        $products = $products
            ->where('sub_category_id', $sub_category_id);

        if ($sort_by == 1) {
            $products = $products
                ->orderBy('id', 'DESC');
        }

        $products = $products
            ->leftJoin('review', 'product.id', '=', 'review.product_id')
            ->select('product.id', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product_type_price.customer_price', 'product_type_price.distributor_price', DB::raw('SUM(star) AS star_sum'))
            ->groupBy('product.id', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product_type_price.customer_price', 'product_type_price.distributor_price')
            ->paginate(20);

        if ($request->ajax()) {
            return view('web.product.ajax.presult', compact('products'));
        }

        $sub_category_record = DB::table('sub_category')
                ->where('id', $sub_category_id)
                ->where('status', 1)
                ->first();

        $top_category_record = DB::table('top_category')
            ->where('status', 1)
            ->get();

        $top_sub_category = [];
        foreach ($top_category_record as $key => $item) {
            
            $sub_category_records = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->select('sub_category.id', 'sub_category.sub_cate_name', 'sub_category.slug')
                ->get();

            $top_sub_category [] = [
                'id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'slug' => $item->slug,
                'sub_category' => $sub_category_records
            ];
        }

        return view('web.product.product_list', compact('products', 'sub_category_record', 'top_sub_category'));
    }

    public function productPriceChecking(Request $request) 
    {
        $product_price = DB::table('product_type_price')
            ->where('product_id', $request->input('product_id'))
            ->where('type', $request->input('product_type'))
            ->first();

        $product = DB::table('product')
            ->where('id', $request->input('product_id'))
            ->first();

        if (Auth::check()){
            if(Auth::guard('users')->user()->user_role == 2)
                $price = $product_price->distributor_price;
            else
                $price = $product_price->customer_price;
        }
        else
            $price = $product_price->customer_price;

        $selling_price = $price;

        if (!empty($product->discount)) {
            $discount = ($price * $product->discount) / 100;
            $selling_price = $price - $discount;
        }

        $data = [
            'original_price' => $price,
            'selling_price' => $selling_price
        ];

        return response()->json($data, 200);
    }

    public function bellBrassProductList(Request $request, $slug, $sub_category_id)
    {
        $products = DB::table('product')
            ->where('sub_category_id', $sub_category_id)
            ->where('product.status', 1)
            ->where('product.deleted_at', NULL);

        $products = $products
            ->select('product.id', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product.customer_price', 'product.distributor_price', 'product.stock')
            ->groupBy('product.id', 'product.product_name', 'product.slug', 'product.banner', 'product.sub_category_id', 'product.discount', 'product.customer_price', 'product.distributor_price', 'product.stock')
            ->paginate(20);

        if ($request->ajax()) {
            return view('web.product.metal.ajax.presult', compact('products'));
        }
        
        $top_category_record = DB::table('top_category')
            ->where('status', 1)
            ->get();

        $top_sub_category = [];
        foreach ($top_category_record as $key => $item) {
            
            $sub_category_records = DB::table('sub_category')
                ->where('top_category_id', $item->id)
                ->where('status', 1)
                ->select('sub_category.id', 'sub_category.sub_cate_name', 'sub_category.slug')
                ->get();

            $top_sub_category [] = [
                'id' => $item->id,
                'top_cate_name' => $item->top_cate_name,
                'slug' => $item->slug,
                'sub_category' => $sub_category_records
            ];
        } 

        return view('web.product.metal.product_list', compact('products', 'top_sub_category'));
    }
}
