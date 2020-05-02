<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UsersController extends Controller
{
    public function usersList()
    {
        return view('admin.users.users_list');
    }

    public function usersListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'name',
                            3 => 'email',
                            4 => 'contact_no',
                            4 => 'password',
                            5 => 'date',
                            6 => 'action',
                        );

        $totalData = DB::table('users')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $users_data = DB::table('users')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $users_data = DB::table('users')
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('contact_no', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('users')
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('contact_no', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($users_data)) {

            $cnt = 1;

            foreach ($users_data as $single_data) {

                $nestedData['id']         = $cnt;
                $nestedData['name']       = $single_data->name;
                $nestedData['email']      = $single_data->email;
                $nestedData['contact_no'] = $single_data->contact_no;
                $nestedData['password'] = $single_data->original_password;
                $nestedData['date']       = \Carbon\Carbon::parse($single_data->created_at)->toDayDateTimeString();
                $nestedData['action']     = "&emsp;<a href=\"".route('admin.users_profile', ['user_id' => encrypt($single_data->id)])."\" class=\"btn btn-success btn-round\" target=\"_blank\">View Profile</a>&emsp;<a href=\"".route('admin.users_orders_history_list', ['user_id' => encrypt($single_data->id)])."\" class=\"btn btn-primary btn-round\" target=\"_blank\">Order History</a>&emsp;<a href=\"".route('admin.delete_user', ['user_id' => encrypt($single_data->id)])."\" class=\"btn btn-danger btn-round\">Delete</a>";

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

    public function usersProfile($user_id)
    {
        try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_info = DB::table('users')
            ->where('id', $user_id)
            ->first();

        return view('admin.users.profile', ['user_info' => $user_info]);
    }

    public function newSellerList()
    {
        $new_seller = DB::table('users')
            ->where('user_role', 2)
            ->where('verification', 1)
            ->get();

        return view('admin.users.new_seller_list', ['new_seller' => $new_seller]);
    }

    public function confirmSeller($user_id)
    {
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'verification' => 0,
                'status' => 1
            ]);

        return redirect()->back();
    }

    public function deleteUser($user_id)
    {
        try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_order = DB::table('order')
            ->where('user_id', $user_id)
            ->get();

        if (!empty($user_order) && (count($user_order) > 0)) {
            
            foreach ($user_order as $key => $item) {
                
                DB::table('order_detail')
                    ->where('order_id', $item->id)
                    ->delete();
            }

            DB::table('order')
                ->where('user_id', $user_id)
                ->delete();
        }

        DB::table('coupon_user')
            ->where('user_id', $user_id)
            ->delete();

        DB::table('address')
            ->where('user_id', $user_id)
            ->delete();

        DB::table('users')
            ->where('id', $user_id)
            ->delete();

        return redirect()->back();
    }
}
