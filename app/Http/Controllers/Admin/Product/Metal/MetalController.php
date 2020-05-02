<?php

namespace App\Http\Controllers\Admin\Product\Metal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Response;
use Str;
use Carbon\Carbon;

class MetalController extends Controller
{
    public function showMetalProductForm() {

        $top_category = DB::table('top_category')
            ->where('id', 4)
            ->first();

        $sub_category = DB::table('sub_category')
            ->where('top_category_id', 4)
            ->get();

    	return view('admin.product.metal.new_product', ['top_category' => $top_category, 'sub_category' => $sub_category]);
    }

    public function addMetalProduct(Request $request) 
    {
        $request->validate([
            'sub_cate_name'      => 'required',
            'product_name'      => 'required',
            'slug'      => 'required',
            'customer_price'     => 'required',
            'whole_seller_price' => 'required',
            'discount'          => 'required',
            'desc'              => 'required',
            'shipping_amount'   => 'required',
            'weight'   => 'required',
            'stock'              => 'required|numeric',
            'banner'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:width=700,height=1000',
        ]);

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $file   = time().'.'.$banner->getClientOriginalExtension();
         
            $destinationPath = public_path('/assets/product/banner');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);

            DB::table('product')
	            ->insert([ 
	            	'sub_category_id' => $request->input('sub_cate_name'), 
                    'product_name' => $request->input('product_name'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'customer_price' => $request->input('customer_price'),
                    'distributor_price' => $request->input('whole_seller_price'),
                    'discount' => $request->input('discount'), 
                    'stock' => $request->input('stock'), 
                    'shipping_amount' => $request->input('shipping_amount'),
                    'weight' => $request->input('weight'), 
                    'desc' => $request->desc, 
	            	'banner' => $file, 
                    'product_type' => 2, 
                ]);

            $product_id = DB::getPdo()->lastInsertId();
                
            if($request->hasFile('slider_images'))
            {
                if(!File::exists(public_path()."/assets/product/images"))
                    File::makeDirectory(public_path()."/assets/product/images");
                
                for($i = 0; $i < count($request->file('slider_images')); $i++) 
                {
                    $original_file = $request->file('slider_images')[$i];
                    $file   = time().$i.'.'.$original_file->getClientOriginalExtension();
                
                    $destinationPath = public_path('/assets/product/images');
                    $img = Image::make($original_file->getRealPath());
                    $img->save($destinationPath.'/'.$file);

                    DB::table('product_additional_images')
                        ->insert([ 
                            'product_id' => $product_id,
                            'additional_image' => $file, 
                        ]);
                }
            }

            return redirect()->back()->with('msg', 'Product has been added successfully');
        } else 
        	return redirect()->back()->with('msg', 'Please ! select a banner');
    }

    public function metalProductList()
    {
        return view('admin.product.metal.product_list.product_list');
    }

    public function metalProductListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'product_name',
                            2 => 'sub_category',
                            3 => 'customer_price',
                            4 => 'distributor_price',
                            5 => 'discount',
                            6 => 'stock',
                            7 => 'product_banner',
                            8 => 'product_images',
                            9 => 'action',
                        );

        $totalData = DB::table('product')
            ->where('product.product_type', 2)
            ->where('deleted_at', NULL) 
            ->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $product_data = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->where('product.product_type', 2)
                            ->where('deleted_at', NULL) 
                            ->select('product.*', 'sub_category.sub_cate_name')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name')
                            ->where('product.product_type', 2)
                            ->where('deleted_at', NULL) 
                            ->where('sub_category.sub_cate_name','LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name')
                            ->where('product.product_type', 2)
                            ->where('deleted_at', NULL) 
                            ->where('sub_category.sub_cate_name','LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.discount', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($single_data->status == 1)
                    $val = "<a href=\"".route('admin.change_metal_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(0)])."\" class=\"btn btn-primary btn-round\">In-Active</a>";
                else
                    $val = "<a href=\"".route('admin.change_metal_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(1)])."\" class=\"btn btn-primary btn-round\">Active</a>";

                if($single_data->feature_product == 1)
                    $feature_btn = "&emsp;<a href=\"".route('admin.remove_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Remove feature product</a>";
                else
                    $feature_btn = "&emsp;<a href=\"".route('admin.make_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Make a feature product</a>";

                $nestedData['id']            = $cnt;
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['customer_price']  = $single_data->customer_price;
                $nestedData['distributor_price']  = $single_data->distributor_price;
                $nestedData['discount']      = $single_data->discount;
                $nestedData['stock']      = $single_data->stock;

                $nestedData['product_banner']  = "&emsp;<a href=\"".route('admin.edit_metal_product_banner', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-success btn-round\" target=\"_blank\">Change Banner</a>";

                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.metal_additional_product_image_list', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary btn-round\" target=\"_blank\">Product Images List</a>";

                $nestedData['action']  = "&emsp;$val&emsp;<a href=\"".route('admin.view_metal_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-success btn-round\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_metal_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-warning btn-round\" target=\"_blank\">Edit</a>&emsp;$feature_btn&emsp;<a href=\"".route('admin.delete_metal_product', ['product_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\">Delete</a>";

                $data[] = $nestedData;

                $cnt++;
            }
        }

        $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                    );
            
        print json_encode($json_data); 
    }

    public function showEditMetalProductBanner($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $url = route('admin.metal_banner_image', ['product_id' => encrypt($product_id)]);

        return view('admin.product.metal.banner.edit_banner' , ['url' => $url, 'product_id' => $product_id]);
    }

    public function updateMetalProductBanner(Request $request, $product_id)
    {
        $request->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->get();

        if ($request->hasFile('icon')) {
            $banner = $request->file('icon');
            $file   = time().'.'.$banner->getClientOriginalExtension();
         
            $destinationPath = public_path('/assets/product/banner');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);

            File::delete(public_path('assets/product/banner/'.$product_record[0]->banner));
            DB::table('product')
                ->where('id', $product_id)
                ->update([ 
                    'banner' => $file, 
                ]);
        }

        return redirect()->back()->with('msg', 'Banner has been changed');
    }

    public function showMetalProductImageList($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $additional_image_record = DB::table('product_additional_images')
            ->where('product_id', $product_id)
            ->get();

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->get();

        return view('admin.product.metal.additional_image.additional_image' , ['additional_image_record' => $additional_image_record, 'product_record' => $product_record]);
    }

    public function updateMetalProductAdditionalImage(Request $request, $additional_image_id)
    {
        $request->validate([
            'additional_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        try {
            $additional_image_id = decrypt($additional_image_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $additional_image_record = DB::table('product_additional_images')
            ->where('id', $additional_image_id)
            ->get();

        if ($request->hasFile('additional_image')) {
            $additional_image = $request->file('additional_image');
            $file   = time().'.'.$additional_image->getClientOriginalExtension();
         
            $destinationPath = public_path('/assets/product/images');
            $img = Image::make($additional_image->getRealPath());
            $img->save($destinationPath.'/'.$file);

            File::delete(public_path('assets/product/images/'.$additional_image_record[0]->additional_image));
            DB::table('product_additional_images')
                ->where('id', $additional_image_id)
                ->update([ 
                    'additional_image' => $file, 
                ]);
        }

        return redirect()->back();
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

    public function metalAdditionalImage ($additional_image_id) 
    {

        try {
            $additional_image_id = decrypt($additional_image_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $additional_image_record = DB::table('product_additional_images')
            ->where('id', $additional_image_id)
            ->get();

        $path = public_path('assets/product/images/'.$additional_image_record[0]->additional_image);

        if (!File::exists($path)) 
            $response = 404;

        $file     = File::get($path);
        $type     = File::extension($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function changeMetalProductStatus($product_id, $status) 
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        try {
            $status = decrypt($status);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('product')
            ->where('id', $product_id)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }

    public function viewMetalProduct($slug, $product_id)
    {
        // try {
        //     $product_id = decrypt($product_id);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $product_record = DB::table('product')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->where('product.id', $product_id)
            ->select('product.*', 'sub_category.sub_cate_name')
            ->first();
        return view('admin.product.metal.action.view_product', ['product_record' => $product_record]);
    }

    public function showMetalEditProduct ($slug, $product_id) 
    {
        // try {
        //     $product_id = decrypt($product_id);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $top_category = DB::table('top_category')
            ->where('id', 4)
            ->first();

        $sub_category = DB::table('sub_category')
            ->where('top_category_id', 4)
            ->get();

        $product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        return view('admin.product.metal.action.edit_product', ['product_record' => $product_record, 'top_category' => $top_category, 'sub_category' => $sub_category]);
    }

    public function updateMetalProduct(Request $request, $product_id) 
    {
        $request->validate([
            'sub_cate_name' => 'required',
            'product_name' => 'required',
            'slug'  => 'required',
            'customer_price'  => 'required',
            'whole_seller_price' => 'required',
            'discount'      => 'required',
            'stock'      => 'required',
            'shipping_amount'      => 'required',
            'weight'      => 'required',
            'desc'          => 'required',
        ]);

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('product')
                ->where('id', $product_id)
                ->update([ 
                    'sub_category_id' => $request->input('sub_cate_name'), 
                    'product_name' => $request->input('product_name'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'customer_price' => $request->input('customer_price'), 
                    'distributor_price' => $request->input('whole_seller_price'), 
                    'discount' => $request->input('discount'), 
                    'stock' => $request->input('stock'), 
                    'shipping_amount' => $request->input('shipping_amount'),
                    'weight' => $request->input('weight'),
                    'desc' => $request->desc, 
                ]);
        
        return redirect()->back()->with('msg', 'Product has been updated');
    }

    public function uploadProductSlider(Request $request, $product_id) {

        if($request->hasFile('slider_images'))
        {
            for($i = 0; $i < count($request->file('slider_images')); $i++) 
            {
                $original_file = $request->file('slider_images')[$i];
                $file   = time().$i.'.'.$original_file->getClientOriginalExtension();
                
                $destinationPath = public_path('/assets/product/images');
                $img = Image::make($original_file->getRealPath());
                $img->save($destinationPath.'/'.$file);

                 DB::table('product_additional_images')
                    ->insert([ 
                        'product_id' => $product_id,
                        'additional_image' => $file, 
                    ]);
            }
        }

        return redirect()->back();
    }

    public function removeProductSliderImage($image_id)
    {
        $image_data = DB::table('product_additional_images')
            ->where('id', $image_id)
            ->first();

        DB::table('product_additional_images')
            ->where('id', $image_id)
            ->delete();

        File::delete(public_path('assets/product/images/'.$image_data->additional_image));

        return redirect()->back();
    }

    public function makeFeatureProduct($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $feature_product_record_count = DB::table('make_feature_product')
            ->where('product_id', $product_id)
            ->count();

        if($feature_product_record_count > 0)
            return redirect()->back();
        else 
        {
            $feature_product_record_count = DB::table('make_feature_product')->count();
            if ($feature_product_record_count < 10) {
                DB::table('make_feature_product')
                    ->insert([
                        'product_id' => $product_id
                    ]);
            } 
            else {
                $rand_id = rand(1, 10);

                DB::table('make_feature_product')
                    ->where('id', $rand_id)
                    ->update([
                        'product_id' => $product_id
                    ]);
            }
        }

        return redirect()->back();
    }

    public function deleteProduct($product_id) 
    {
        DB::table('product')
            ->where('id', $product_id)
            ->update([
                'feature_product' => 2,
                'deleted_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(), 
            ]);

        DB::table('wishlist')
            ->where('product_id', $product_id)
            ->delete();

        DB::table('cart')
            ->where('product_id', $product_id)
            ->delete();

        return redirect()->back();
    }
}
