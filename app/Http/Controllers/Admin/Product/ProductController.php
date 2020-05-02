<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Response;
use Str;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function showProductForm () 
    {
    	$all_top_category = DB::table('top_category')
            ->where('id', '!=', 4)
            ->get();

        return view('admin.product.new_product', ['data' => $all_top_category]);
    }

    public function retriveSubCategory(Request $request)
    {
    	$all_sub_category = DB::table('sub_category')
    		->where('top_category_id', $request->input('category_id'))
    		->get();

    	$data = "<option value=\"\" disabled selected>Choose Sub-Category</option>";
    	foreach ($all_sub_category as $key => $value)
    		$data = $data."<option value=\"".$value->id."\">".$value->sub_cate_name."</option>";

    	print $data;
    }

    public function productPriceType(Request $request)
    {
        if($request->has('category_id'))
        {
            if($request->input('category_id') == 1)
            {
                $price_form = "<div class=\"form-row mb-3\">
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"type\">Type</label>
                        <input type=\"text\" class=\"form-control form-text-element\"  required value=\"Raw\" disabled>
                        <input type=\"hidden\" name=\"type[]\" class=\"form-control form-text-element\" value=\"2\" required>
                    </div>
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"customer_price\">Customer Price</label>
                        <input type=\"text\" class=\"form-control form-text-element\" name=\"customer_price[]\" value=\"0\" required>
                    </div>
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"whole_seller_price\">Whole Seller Price</label>
                        <input type=\"text\" class=\"form-control form-text-element\" name=\"whole_seller_price[]\" value=\"0\" required>
                    </div>
                </div>
                <div class=\"form-row mb-3\">
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"type\">Type</label>
                        <input type=\"text\" class=\"form-control form-text-element\"  required value=\"Ready to wear\" disabled>
                        <input type=\"hidden\" name=\"type[]\" class=\"form-control form-text-element\" value=\"1\" required>
                    </div>
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"customer_price\">Customer Price</label>
                        <input type=\"text\" class=\"form-control form-text-element\" name=\"customer_price[]\" value=\"0\" required>
                    </div>
                    <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                        <label for=\"whole_seller_price\">Whole Seller Price</label>
                        <input type=\"text\" class=\"form-control form-text-element\" name=\"whole_seller_price[]\" value=\"0\" required>
                    </div>
                </div>";

                print $price_form;
            } else {

                $price_form_1 = "<div class=\"form-row mb-3\">
                <div class=\"col-md-6 col-sm-12 col-xs-12 mb-3\">
                    <label for=\"customer_price\">Customer Price</label>
                    <input type=\"text\" class=\"form-control form-text-element\" name=\"customer_price\" required>
                </div>

                <div class=\"col-md-6 col-sm-12 col-xs-12 mb-3\">
                    <label for=\"whole_seller_price\">Whole Seller Price</label>
                    <input type=\"text\" class=\"form-control form-text-element\" name=\"whole_seller_price\" required>
                </div>
            </div>";

            $price_form = "<div class=\"form-row mb-3\">
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"type\">Type</label>
                <input type=\"text\" class=\"form-control form-text-element\"  required value=\"Raw\" disabled>
                <input type=\"hidden\" name=\"type[]\" class=\"form-control form-text-element\" value=\"2\" required>
            </div>
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"customer_price\">Customer Price</label>
                <input type=\"text\" class=\"form-control form-text-element\" name=\"customer_price[]\" value=\"0\" required>
            </div>
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"whole_seller_price\">Whole Seller Price</label>
                <input type=\"text\" class=\"form-control form-text-element\" name=\"whole_seller_price[]\" value=\"0\" required>
            </div>
        </div>
        <div class=\"form-row mb-3\">
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"type\">Type</label>
                <input type=\"text\" class=\"form-control form-text-element\"  required value=\"Ready to wear\" disabled>
                <input type=\"hidden\" name=\"type[]\" class=\"form-control form-text-element\" value=\"1\" required>
            </div>
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"customer_price\">Customer Price</label>
                <input type=\"text\" class=\"form-control form-text-element\" name=\"customer_price[]\" value=\"0\" required>
            </div>
            <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\">
                <label for=\"whole_seller_price\">Whole Seller Price</label>
                <input type=\"text\" class=\"form-control form-text-element\" name=\"whole_seller_price[]\" value=\"0\" required>
            </div>
        </div>";

                print $price_form;
            }
        }
    }

    // public function retriveColor(Request $request)
    // {
    //     $all_color = DB::table('color_mapping')
    //         ->leftJoin('color', 'color_mapping.color_id', '=', 'color.id')
    //         ->where('color_mapping.sub_category_id', $request->input('sub_category_id'))
    //         ->get();

    //     $data_1 = "";
    //     foreach ($all_color as $key => $value)
    //         $data_1 = $data_1."<input type=\"checkbox\" name=\"color_id[]\" value=\"".$value->id."\"> ".$value->color." ";

    //     print $data_1;
    // }

    public function addProduct(Request $request) 
    {
        $request->validate([
            'sub_cate_name'     => 'required',
            'product_name'      => 'required',
            'slug'      => 'required',
            'top_cate_name' => 'required',
            'shipping_amount'      => 'required',
            'discount'          => 'required',
            'desc'              => 'required',
            'stock'              => 'required|numeric',
            'banner'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:width=700,height=1000',
        ]);

        if($request->input('top_cate_name') == 1){

            $request->validate([
                'type'              => 'required',
                'customer_price'    => 'required',
                'whole_seller_price'=> 'required',
            ]);
        } else {

            $request->validate([
                'customer_price'    => 'required',
                'whole_seller_price'=> 'required',
            ]);
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $file   = time().'.'.$banner->getClientOriginalExtension();

            if(!File::exists(public_path()."/assets"))
                File::makeDirectory(public_path()."/assets");

            if(!File::exists(public_path()."/assets/product"))
                File::makeDirectory(public_path()."/assets/product");

            if(!File::exists(public_path()."/assets/product/banner"))
                File::makeDirectory(public_path()."/assets/product/banner");
         
            $destinationPath = public_path('/assets/product/banner');
            $img = Image::make($banner->getRealPath());
            $img->save($destinationPath.'/'.$file);

            DB::table('product')
                ->insert([ 
                    'sub_category_id' => $request->input('sub_cate_name'), 
                    'product_name' => $request->input('product_name'), 
                    'color' => $request->input('color'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'discount' => $request->input('discount'), 
                    'stock' => $request->input('stock'), 
                    'shipping_amount' => $request->input('shipping_amount'),
                    'desc' => $request->desc, 
                    'banner' => $file, 
                    'product_type' => 1
                ]);

            $product_id = DB::getPdo()->lastInsertId();

            for ($i=0; $i < count($request->input('type')); $i++) { 
                DB::table('product_type_price')
                    ->insert([
                        'product_id' => $product_id,
                        'type' => $request->input('type')[$i],
                        'customer_price' => $request->input('customer_price')[$i],
                        'distributor_price' => $request->input('whole_seller_price')[$i],
                    ]);
            }
            
            // if($request->input('top_cate_name') == 1){

            //     for ($i=0; $i < count($request->input('type')); $i++) { 
            //         DB::table('product_type_price')
            //             ->insert([
            //                 'product_id' => $product_id,
            //                 'type' => $request->input('type')[$i],
            //                 'customer_price' => $request->input('customer_price')[$i],
            //                 'distributor_price' => $request->input('whole_seller_price')[$i],
            //             ]);
            //     }
            // } else {

            //     DB::table('product')
            //         ->where('id', $product_id)
            //         ->update([ 
            //             'customer_price' => $request->input('customer_price'), 
            //             'distributor_price' => $request->input('whole_seller_price'), 
            //         ]);
            // }
                
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

            // if($request->has('color_id'))
            // {
            //     for($i = 0; $i < count($request->input('color_id')); $i++) 
            //     {
            //         DB::table('product_color_mapping')
            //             ->insert([ 
            //                 'product_id' => $product_id,
            //                 'color_id' => $request->input('color_id')[$i], 
            //             ]);
            //     }
            // }

            return redirect()->back()->with('msg', 'Product has been added successfully');

        } else 
        	return redirect()->back()->with('msg', 'Please ! select a banner');
    }

    // public function productStockEntry($slug, $product_id)
    // {
    //     // try {
    //     //     $product_id = decrypt($product_id);
    //     // }catch(DecryptException $e) {
    //     //     return redirect()->back();
    //     // }

    //     $product = DB::table('product')
    //         ->where('id', $product_id)
    //         ->first();

    //     return view('admin.product.product_stock_entry', ['product' => $product]);
    // }

    // public function addStockEntry(Request $request, $product_id)
    // {
    //     $request->validate([
    //         'type' => 'required',
    //         'customer_price' => 'required',
    //         'whole_seller_price' => 'required'
    //     ]);

    //     try {
    //         $product_id = decrypt($product_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     for ($i=0; $i < count($request->input('type')); $i++) { 
    //         DB::table('product_type_price')
    //             ->insert([
    //                 'product_id' => $product_id,
    //                 'type' => $request->input('type')[$i],
    //                 'customer_price' => $request->input('customer_price')[$i],
    //                 'distributor_price' => $request->input('whole_seller_price')[$i],
    //             ]);
    //     }

    //     return redirect()->route('admin.new_product')->with('msg', 'Product has been added sucessfully');
    // }

    public function productList()
    {
        return view('admin.product.product_list.product_list');
    }

    public function productListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'product_name',
                            2 => 'color',
                            3 => 'sub_category',
                            4 => 'top_category',
                            5 => 'discount',
                            6 => 'product_banner',
                            7 => 'product_images',
                            8 => 'action',
                        );

        $totalData = DB::table('product')
            ->where('product.product_type', 1) 
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
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->where('product.product_type', 1)
                            ->where('deleted_at', NULL)
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->where('product.product_type', 1)
                            ->where('deleted_at', NULL)
                            ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->where('product.product_type', 1)
                            ->where('deleted_at', NULL)
                            ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.discount', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($single_data->status == 1)
                    $val = "<a href=\"".route('admin.change_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(0)])."\" class=\"btn btn-primary btn-round\">In-Active</a>";
                else
                    $val = "<a href=\"".route('admin.change_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(1)])."\" class=\"btn btn-primary btn-round\">Active</a>";

                if($single_data->feature_product == 1)
                    $feature_btn = "&emsp;<a href=\"".route('admin.remove_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Remove feature product</a>";
                else
                    $feature_btn = "&emsp;<a href=\"".route('admin.make_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Make a feature product</a>";

                $nestedData['id']            = $cnt;
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['color']  = $single_data->color;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['top_category']  = $single_data->top_cate_name;
                $nestedData['discount']      = $single_data->discount;
                $nestedData['product_banner']  = "&emsp;<a href=\"".route('admin.edit_product_banner', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-success btn-round\" target=\"_blank\">Change Banner</a>";
                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.additional_product_image_list', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary btn-round\" target=\"_blank\">Product Images List</a>";
                $nestedData['action']  = "&emsp;<a href=\"".route('admin.view_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-success btn-round\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-warning btn-round\" target=\"_blank\">Edit</a>&emsp;<a href=\"".route('admin.edit_product_stock', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\" target=\"_blank\">Price</a>&emsp;$val$feature_btn&emsp;<a href=\"".route('admin.delete_product', ['product_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\">Delete</a>";

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

    public function showEditProductBanner($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $url = route('admin.banner_image', ['product_id' => encrypt($product_id)]);

        return view('admin.product.banner.edit_banner' , ['url' => $url, 'product_id' => $product_id]);
    }

    public function showProductImageList($product_id)
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

        return view('admin.product.additional_image.additional_image' , ['additional_image_record' => $additional_image_record, 'product_record' => $product_record]);
    }

    public function updateProductBanner(Request $request, $product_id)
    {
        $request->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=700,max_height=1000',
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

    public function updateProductAdditionalImage(Request $request, $additional_image_id)
    {
        $request->validate([
            'additional_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240|dimensions:max_width=700,max_height=1000',
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

    public function additionalImage ($additional_image_id) 
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

    public function viewProduct($slug, $product_id)
    {
        // try {
        //     $product_id = decrypt($product_id);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $product_record = DB::table('product')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->where('product.id', $product_id)
            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
            ->get();

        // $colors = DB::table('product_color_mapping')
        //     ->leftJoin('color', 'product_color_mapping.color_id', '=', 'color.id')
        //     ->where('product_color_mapping.product_id', $product_id)
        //     ->select('color.color')
        //     ->get();

        // $extract_colors = "";
        // foreach ($colors as $key => $value)
        //     $extract_colors = $value->color.", ".$extract_colors;

        $product_price = DB::table('product_type_price')
            ->where('product_id', $product_id)
            ->get();

        return view('admin.product.action.view_product', ['product_record' => $product_record, 'product_price' => $product_price]);
    }

    public function showEditProduct ($slug, $product_id) 
    {
        // try {
        //     $product_id = decrypt($product_id);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $product_record = DB::table('product')
            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->where('product.id', $product_id)
            ->select('product.*', 'top_category.id as top_cate_id')
            ->get();

        $all_top_category = DB::table('top_category')->get();
        $all_sub_category = DB::table('sub_category')
            ->where('top_category_id', $product_record[0]->top_cate_id)
            ->get();

        return view('admin.product.action.edit_product', ['all_top_category' => $all_top_category, 'all_sub_category' => $all_sub_category, 'product_record' => $product_record]);
    }

    public function updateProduct(Request $request, $product_id) 
    {
        $request->validate([
            'sub_cate_name' => 'required',
            'product_name'  => 'required',
            'slug' => 'required',
            'shipping_amount' => 'required',
            'discount'      => 'required',
            'desc'          => 'required',
            'stock'          => 'required|numeric',
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
                    'color' => $request->input('color'), 
                    'slug' => strtolower(Str::slug($request->input('slug'), '-')), 
                    'discount' => $request->input('discount'), 
                    'stock' => $request->input('stock'), 
                    'shipping_amount' => $request->input('shipping_amount'), 
                    'desc' => $request->desc, 
                ]);
        
        return redirect()->back()->with('msg', 'Product has been updated');
    }

    // public function showEditProductColor ($slug, $product_id) 
    // {
    //     // try {
    //     //     $product_id = decrypt($product_id);
    //     // }catch(DecryptException $e) {
    //     //     return redirect()->back();
    //     // }

    //     $product_colors = DB::table('product_color_mapping')
    //         ->leftJoin('color', 'product_color_mapping.color_id', '=', 'color.id')
    //         ->where('product_color_mapping.product_id', $product_id)
    //         ->select('product_color_mapping.*', 'color.color')
    //         ->get();

    //     $product_record = DB::table('product')
    //         ->where('product.id', $product_id)
    //         ->get();
        
    //     $all_color = DB::table('color_mapping')
    //         ->leftJoin('color', 'color_mapping.color_id', '=', 'color.id')
    //         ->where('color_mapping.sub_category_id', $product_record[0]->sub_category_id)
    //         ->get();

    //     return view('admin.product.action.edit_product_colors', ['product_colors' => $product_colors, 'all_color' => $all_color, 'product_record' => $product_record]);
    // }

    // public function updateProductColor(Request $request, $product_id) 
    // {
    //     $request->validate([
    //         'color' => 'required',
    //     ]);

    //     try {
    //         $product_id = decrypt($product_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     $count = DB::table('product_color_mapping')
    //         ->where('product_id', $product_id)
    //         ->where('color_id', $request->input('color'))
    //         ->count();

    //     if ($count > 0)
    //         return redirect()->back()->with('msg', 'Product Color already in the list');
    //     else {

    //         DB::table('product_color_mapping')
    //                 ->insert([ 
    //                     'product_id' => $product_id,
    //                     'color_id' => $request->input('color'), 
    //                 ]);

    //         return redirect()->back()->with('msg', 'Product Color has been updated');
    //     }
    // }

    // public function changeProductColorStatus($product_mapping_id, $status) 
    // {
    //     try {
    //         $product_mapping_id = decrypt($product_mapping_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     try {
    //         $status = decrypt($status);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     DB::table('product_color_mapping')
    //         ->where('id', $product_mapping_id)
    //         ->update([
    //             'status' => $status
    //         ]);

    //     return redirect()->back();
    // }

    public function showEditProductStock($slug, $product_id) 
    {
        // try {
        //     $product_id = decrypt($product_id);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        // $product_color = DB::table('product_color_mapping')
        //     ->leftJoin('color', 'product_color_mapping.color_id', '=', 'color.id')
        //     ->where('product_color_mapping.product_id', $product_id)
        //     ->select('color.*')
        //     ->get();

        $product_price = DB::table('product_type_price')
            ->where('product_id', $product_id)
            ->get();

        return view('admin.product.action.edit_product_stock', ['product_id' => $product_id, 'product_price' => $product_price]);
    }

    public function updateProductStock(Request $request, $product_id) 
    {
        $request->validate([
            'type' => 'required',
            'customer_price' => 'required',
            'whole_seller_price' => 'required'
        ]);

        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        for ($i=0; $i < count($request->input('type')); $i++) {
         
            $count = DB::table('product_type_price')
                ->where('product_id', $product_id)
                ->where('type', $request->input('type')[$i])
                ->count();

            if ($count > 0) {
                DB::table('product_type_price')
                    ->where('product_id', $product_id)
                    ->where('type', $request->input('type')[$i])
                    ->update([
                        'customer_price' => $request->input('customer_price')[$i],
                        'distributor_price' => $request->input('whole_seller_price')[$i]
                    ]);
            } 
            else
            {
                DB::table('product_type_price')
                    ->insert([
                        'product_id' => $product_id,
                        'type' => $request->input('type')[$i],
                        'customer_price' => $request->input('customer_price')[$i],
                        'distributor_price' => $request->input('whole_seller_price')[$i],
                    ]);
            }
        }

        return redirect()->back()->with('msg', 'Price has added updated');
    }

    public function changeProductStatus($product_id, $status) 
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

    public function activeProductList()
    {
        return view('admin.product.product_list.active_product_list');
    }

    public function inactiveProductList()
    {
        return view('admin.product.product_list.in_active_product_list');
    }

    public function activeInactiveProductListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            1 => 'product_name',
                            2 => 'color',
                            3 => 'sub_category',
                            4 => 'top_category',
                            5 => 'discount',
                            6 => 'product_banner',
                            7 => 'product_images',
                            8 => 'action',
                        );

        $totalData = DB::table('product')
            ->where('status', $request->input('status'))
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
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->where('product_type', 1)
                            ->where('deleted_at', NULL)
                            ->where('product.status', $request->input('status'))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $product_data = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->where('product_type', 1)
                            ->where('deleted_at', NULL)
                            ->where('product.status', $request->input('status'))
                            ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.discount', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('product')
                            ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
                            ->select('product.*', 'sub_category.sub_cate_name', 'top_category.top_cate_name')
                            ->where('product_type', 1)
                            ->where('deleted_at', NULL)
                            ->where('product.status', $request->input('status'))
                            ->where('top_category.top_cate_name','LIKE',"%{$search}%")
                            ->orWhere('sub_category.sub_cate_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.product_name', 'LIKE',"%{$search}%")
                            ->orWhere('product.discount', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($product_data)) {

            $cnt = 1;

            foreach ($product_data as $single_data) {

                if($request->input('status') == 1)
                    $val = "<a href=\"".route('admin.change_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(0)])."\" class=\"btn btn-primary btn-round\">In-Active</a>";
                else
                    $val = "<a href=\"".route('admin.change_product_status', ['product_id' => encrypt($single_data->id), 'status' => encrypt(1)])."\" class=\"btn btn-primary btn-round\">Active</a>";

                if($single_data->feature_product == 1)
                    $feature_btn = "&emsp;<a href=\"".route('admin.remove_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Remove feature product</a>";
                else
                    $feature_btn = "&emsp;<a href=\"".route('admin.make_feature_product', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Make a feature product</a>";

                $nestedData['id']            = $cnt;
                $nestedData['product_name']  = $single_data->product_name;
                $nestedData['color']  = $single_data->color;
                $nestedData['sub_category']  = $single_data->sub_cate_name;
                $nestedData['top_category']  = $single_data->top_cate_name;
                $nestedData['discount']      = $single_data->discount;
                $nestedData['product_banner']  = "&emsp;<a href=\"".route('admin.edit_product_banner', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-success btn-round\" target=\"_blank\">Change Banner</a>";
                $nestedData['product_images']  = "&emsp;<a href=\"".route('admin.additional_product_image_list', ['product_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary btn-round\" target=\"_blank\">Product Images List</a>";
                
                $nestedData['action']  = "&emsp;<a href=\"".route('admin.view_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-success btn-round\" target=\"_blank\">View</a>&emsp;<a href=\"".route('admin.edit_product', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-warning btn-round\" target=\"_blank\">Edit</a>&emsp;<a href=\"".route('admin.edit_product_stock', ['slug' => $single_data->slug, 'product_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\" target=\"_blank\">Price</a>&emsp;$val$feature_btn&emsp;<a href=\"".route('admin.delete_product', ['product_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\">Delete</a>";

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

    public function makeFeatureProduct($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $feature_product_record = DB::table('product')
            ->where('id', $product_id)
            ->first();

        if($feature_product_record->feature_product == 1)
            return redirect()->back();
        else 
        {
            $feature_product_record_count = DB::table('product')
                ->where('feature_product', 1)
                ->count();

            if ($feature_product_record_count <= 10) {
                DB::table('product')
                    ->where('id', $product_id)
                    ->update([
                        'feature_product' => 1
                    ]);
            } 
            // else {
            //     $rand_id = rand(1, 10);

            //     DB::table('make_feature_product')
            //         ->where('id', $rand_id)
            //         ->update([
            //             'product_id' => $product_id
            //         ]);
            // }
        }

        return redirect()->back();
    }

    public function removeFeatureProduct($product_id)
    {
        try {
            $product_id = decrypt($product_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('product')
                    ->where('id', $product_id)
                    ->update([
                        'feature_product' => 2
                    ]);

        return redirect()->back();
    }

    // public function mostPopularProduct($product_id)
    // {
    //     try {
    //         $product_id = decrypt($product_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     $most_popular_product_record_count = DB::table('most_popular_product')
    //         ->where('product_id', $product_id)
    //         ->count();

    //     if($most_popular_product_record_count > 0)
    //         return redirect()->back();
    //     else 
    //     {
    //         $most_popular_product_record_count = DB::table('most_popular_product')->count();
    //         if ($most_popular_product_record_count < 10) {
    //             DB::table('most_popular_product')
    //                 ->insert([
    //                     'product_id' => $product_id
    //                 ]);
    //         } 
    //         else {
    //             $rand_id = rand(1, 10);

    //             DB::table('most_popular_product')
    //                 ->where('id', $rand_id)
    //                 ->update([
    //                     'product_id' => $product_id
    //                 ]);
    //         }
    //     }

    //     return redirect()->back();
    // }

    // public function bestSellerProduct($product_id)
    // {
    //     try {
    //         $product_id = decrypt($product_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }

    //     $best_seller_product_record_count = DB::table('best_seller_product')
    //         ->where('product_id', $product_id)
    //         ->count();

    //     if($best_seller_product_record_count > 0)
    //         return redirect()->back();
    //     else 
    //     {
    //         $best_seller_product_record_count = DB::table('best_seller_product')->count();
    //         if ($best_seller_product_record_count < 10) {
    //             DB::table('best_seller_product')
    //                 ->insert([
    //                     'product_id' => $product_id
    //                 ]);
    //         } 
    //         else {
    //             $rand_id = rand(1, 10);

    //             DB::table('best_seller_product')
    //                 ->where('id', $rand_id)
    //                 ->update([
    //                     'product_id' => $product_id
    //                 ]);
    //         }
    //     }

    //     return redirect()->back();
    // }

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
