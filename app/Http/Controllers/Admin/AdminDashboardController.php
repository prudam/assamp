<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    public function index(){

    	$total_user = DB::table('users')
    		->count();

    	$total_order = DB::table('order')
    		->count();

        $total_product = DB::table('product')
            ->count();


    	$latest_ten_order = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.order_status', 1)
                            ->limit(6)
                            ->orderBy('order.id', 'DESC')
                            ->get();

    	return view('admin.dashboard', ['total_user' => $total_user, 'total_order' => $total_order, 'total_product' => $total_product, 'latest_ten_order' => $latest_ten_order]);
    }

    public function showChangePasswordForm()
    {
        return view('admin.change_password');
    }

    protected function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'same:confirm_password'],
        ]);

        DB::table('admin')
            ->update([
                'password' => Hash::make($request->input('password')),
            ]);

        return redirect()->back()->with('msg', 'Password has been updated');
    }

    public function showCartQuanitytForm()
    {
        $data = DB::table('cart_quantity_for_seller')
            ->first();
        return view('admin.cart_quantity.cart_quantity', ['data' => $data]);
    }

    protected function updateCartQuanityt(Request $request)
    {
        $request->validate([
            'qty' => 'required|numeric',
        ]);

        DB::table('cart_quantity_for_seller')
            ->update([
                'qty' => $request->input('qty'),
            ]);

        return redirect()->back()->with('msg', 'Quantity has been updated');
    }
}
