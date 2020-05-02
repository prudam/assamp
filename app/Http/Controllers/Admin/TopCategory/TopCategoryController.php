<?php

namespace App\Http\Controllers\Admin\TopCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use File;
use Str;

class TopCategoryController extends Controller
{
    public function allTopCategory () 
    {
    	$all_top_category = DB::table('top_category')->get();
        return view('admin.top_category.all_top_category', ['data' => $all_top_category]);
    }

    public function showEditTopCategoryForm($slug, $topCategoryId) 
    {
    	// try {
     //        $topCategoryId = decrypt($topCategoryId);
     //    }catch(DecryptException $e) {
     //        return redirect()->back();
     //    }

        $top_category_record = DB::table('top_category')
        	->where('id', $topCategoryId)
        	->get();

        return view('admin.top_category.edit_top_category', ['data' => $top_category_record]);
    }

    public function updateTopCategory(Request $request, $topCategoryId) 
    {
        $this->validate($request, [
            'top_cate_name' => 'required'
        ]);

        try {
            $topCategoryId = decrypt($topCategoryId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $old_file_name = DB::table('top_category')
            ->where('id', $topCategoryId)
            ->get();

        DB::table('top_category')
            ->where('id', $topCategoryId)
            ->update([ 
                'top_cate_name' => $request->input('top_cate_name'),
                'slug' => strtolower(Str::slug($request->input('slug'), '-'))
            ]);

        return redirect()->route('admin.edit_top_category', ['slug' => strtolower(Str::slug($request->input('slug'), '-')), 'topCategoryId' => $topCategoryId])->with('msg', 'Top-Category has been updated successfully');
    }

    public function updateStatus($topCategoryId, $status)
    {
        DB::table('top_category')
            ->where('id', $topCategoryId)
            ->update([
                'status' => $status
            ]);

        return redirect()->back();
    }
}
