<?php

namespace App\Http\Controllers\Admin\SubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Str;

class SubCategoryController extends Controller
{
    public function showSubCategoryForm () 
    {
    	$all_top_category = DB::table('top_category')->get();
        return view('admin.sub_category.new_sub_category', ['data' => $all_top_category]);
    }

    public function addSubCategory(Request $request) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug' => 'required',
        ]);

         DB::table('sub_category')
            ->insert([ 
                'top_category_id' => $request->input('top_cate_name'), 
                'sub_cate_name' => $request->input('sub_cate_name'),
                'slug' => strtolower(Str::slug($request->input('slug'), '-'))
            ]);

        return redirect()->back()->with('msg', 'Sub-Category has been added successfully');
    }

    public function allSubCategory () 
    {
        $all_sub_category = DB::table('sub_category')
            ->leftJoin('top_category', 'sub_category.top_category_id', '=', 'top_category.id')
            ->select('sub_category.*', 'top_category.top_cate_name')
            ->get();

        return view('admin.sub_category.all_sub_category', ['data' => $all_sub_category]);
    }

    public function showEditSubCategoryForm($slug, $subCategoryId) 
    {
        // try {
        //     $subCategoryId = decrypt($subCategoryId);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $sub_category_record = DB::table('sub_category')
            ->where('id', $subCategoryId)
            ->get();

        $all_top_category = DB::table('top_category')->get();

        return view('admin.sub_category.edit_sub_category', ['data' => $sub_category_record, 'all_top_category' => $all_top_category]);
    }

    public function updateSubCategory(Request $request, $subCategoryId) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required',
            'sub_cate_name' => 'required',
            'slug' => 'required'
        ]);

        try {
            $subCategoryId = decrypt($subCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $old_file_name = DB::table('sub_category')
            ->where('id', $subCategoryId)
            ->get();

        DB::table('sub_category')
            ->where('id', $subCategoryId)
            ->update([ 
                'top_category_id' => $request->input('top_cate_name'),
                'sub_cate_name' => $request->input('sub_cate_name'),
                'slug' => strtolower(Str::slug($request->input('slug'), '-')),
            ]);

        return redirect()->route('admin.edit_sub_category', ['slug' => strtolower(Str::slug($request->input('slug'), '-')), 'subCategoryId' => $subCategoryId])->with('msg', 'Sub-Category has been updated successfully');
    }

    public function updateStatus($subCategoryId, $status)
    {
        DB::table('sub_category')
            ->where('id', $subCategoryId)
            ->update([
                'status' => $status
            ]);

        if($status == 1) {

            DB::table('product')
            ->where('sub_category_id', $subCategoryId)
            ->update([
                'status' => 1
            ]);
        }

        if($status ==2) {

            DB::table('product')
            ->where('sub_category_id', $subCategoryId)
            ->update([
                'status' => 0
            ]);
        }

        return redirect()->back();
    }
}
