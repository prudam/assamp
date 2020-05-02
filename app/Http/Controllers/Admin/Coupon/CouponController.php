<?php

namespace App\Http\Controllers\Admin\Coupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Str;

class CouponController extends Controller
{
    public function showCouponForm () 
    {
        return view('admin.coupon.new_coupon');
    }

    public function addCoupon(Request $request) 
    {
        $this->validate($request, [
            'user_type' => 'required',
            'coupon_type' => 'required',
            'coupon_amount' => 'required',
            'coupon_code' => 'required',
        ]);

        $coupon_code_check = DB::table('coupon')
            ->where('coupon_code' , $request->input('coupon_code'))
            ->count();

        if ($coupon_code_check > 0) {
            return redirect()->back()->with('msg', 'Coupon Code already added');
        } else {

            $coupon_check = DB::table('coupon')
                ->where('user_type' , $request->input('user_type'))
                ->where('coupon_type' , $request->input('coupon_type'))
                ->count();

            if($coupon_check > 0){
                
                DB::table('coupon')
                    ->where('user_type' , $request->input('user_type'))
                    ->where('coupon_type' , $request->input('coupon_type'))
                    ->update([
                        'status' => 2
                    ]);
            } 

            DB::table('coupon')
                ->insert([ 
                    'user_type' => $request->input('user_type'),
                    'coupon_type' => $request->input('coupon_type'), 
                    'coupon_code' => $request->input('coupon_code'),
                    'coupon_amount' => $request->input('coupon_amount'),
                    'coupon_desc' => $request->input('coupon_desc'),
                ]);

            return redirect()->back()->with('msg', 'Coupon has been added successfully');
        }
    }

    public function allCoupon () 
    {
        $all_coupon = DB::table('coupon')->get();

        return view('admin.coupon.all_coupon', ['data' => $all_coupon]);
    }

    public function couponStatusUpdate($couponId, $status){

        $coupon_details = DB::table('coupon')
            ->where('id' , $couponId)
            ->first();

        if($status == 1){
        
            DB::table('coupon')
                ->where('user_type' , $coupon_details->user_type)
                ->where('coupon_type' , $coupon_details->coupon_type)
                ->update([
                    'status' => 2
                ]);
        } else {

            DB::table('coupon')
                ->where('user_type' , $coupon_details->user_type)
                ->where('coupon_type' , $coupon_details->coupon_type)
                ->update([
                    'status' => 1
                ]);
        }
        
        DB::table('coupon')
        ->where('id' , $couponId)
        ->update([
            'status' => $status,
        ]);

        return redirect()->back();
    }

    public function showEditCouponForm($couponId) 
    {
        // try {
        //     $subCategoryId = decrypt($subCategoryId);
        // }catch(DecryptException $e) {
        //     return redirect()->back();
        // }

        $coupon_record = DB::table('coupon')
            ->where('id', $couponId)
            ->first();

        return view('admin.coupon.edit_coupon', ['data' => $coupon_record]);
    }

    public function updateCoupon(Request $request, $couponId) 
    {
        $this->validate($request, [
            'coupon_amount' => 'required',
            'coupon_code' => 'required',
            'coupon_desc' => 'required',
        ]);

        try {
            $couponId = decrypt($couponId);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $coupon_code_check = DB::table('coupon')
            ->where('coupon_code' , $request->input('coupon_code'))
            ->count();

        if ($coupon_code_check > 0) {
            DB::table('coupon')
                ->where('id', $couponId)
                ->update([ 
                    'coupon_amount' => $request->input('coupon_amount'),
                    'coupon_desc' => $request->input('coupon_desc'),
                ]);
        } else {
            DB::table('coupon')
                ->where('id', $couponId)
                ->update([ 
                    'coupon_amount' => $request->input('coupon_amount'),
                    'coupon_code' => $request->input('coupon_code'),
                    'coupon_desc' => $request->input('coupon_desc'),
                ]);
        }

        return redirect()->back();
    }
}
