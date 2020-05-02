<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Mail\OrderEmail;
use Mail;

class OrdersController extends Controller
{
    public function newOrdersList()
    {
    	return view('admin.orders.new_orders');
    }

    public function outForDeliveryOrdersList()
    {
    	return view('admin.orders.out_for_delivery_orders');
    }

    public function deliveredOrdersList()
    {
    	return view('admin.orders.delivered_orders');
    }

    public function canceledOrdersList()
    {
    	return view('admin.orders.canceled_orders');
    }

    public function ordersListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'order_id',
                            3 => 'user_name',
                            4 => 'payment_id',
                            5 => 'payment_status',
                            6 => 'order_date',
                            7 => 'action',
                        );

        $totalData = DB::table('order')
        	->where('order_status', $request->input('status'))
        	->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name', 'users.user_role')
                            ->where('order.order_status', $request->input('status'))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name', 'users.user_role')
                            ->where('order.order_status', $request->input('status'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name', 'users.user_role')
                            ->where('order.order_status', $request->input('status'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($order_data)) {

            $cnt = 1;

            foreach ($order_data as $single_data) {

                if($single_data->order_status == 1)
                    $val = "&emsp;<a href=\"".route('admin.order_status_update', ['order_id' => encrypt($single_data->id), 'status' => encrypt(2)])."\" class=\"btn btn-primary btn-round\">Accept Order</a>";

                else if($single_data->order_status == 2)
                    $val = "&emsp;";
                else if($single_data->order_status == 4)
                    $val = "&emsp;";
                else
                    $val = "&emsp;";

                $delete = ""; 
                $files = "";
                if (empty($single_data->payment_status)) {
                	$payment_status = "Cash";
                	$document = DB::table('orde_file')
                        ->where('order_id', $single_data->id)
                        ->get();

                    if(!empty($document)){
                        foreach ($document as $key => $item_3){

                            $url = asset('assets/doc/'.$item_3->file.'');
                            $idd = ($key + 1);
                            $files = $files."<a href=\"$url\" target=\"_blank\" style=\"font-weight: bold;\">Document $idd</a>&emsp;&emsp;";
                        }
                    }
                }
                else 
                {
                	if($single_data->payment_status == 1){

	                	$payment_status = "Failed";
                        $delete = "&emsp;<a href=\"".route('admin.delete_order', ['order_id' => $single_data->id])."\" class=\"btn btn-danger btn-round\">Delete Order</a>";
                    }
	                else
	                	$payment_status = "Paid";
                }

                if($single_data->user_role == 1)
                    $user_type = "Retail Customer";
                else
                    $user_type = "Seller";

                $nestedData['id']             = $cnt;
                $nestedData['order_id']       = $single_data->order_id;
                $nestedData['user_name']      = "<a href=\"".route('admin.users_profile', ['user_id' => encrypt($single_data->user_id)])."\" title=\"View User Detail\" target=\"_blank\">$single_data->name</a>";
                $nestedData['customer_type']     = $user_type;
                $nestedData['payment_id']     = $single_data->payment_id;
                $nestedData['payment_status'] = $payment_status;
                $nestedData['order_date']     = \Carbon\Carbon::parse($single_data->created_at)->toDayDateTimeString();
                $nestedData['facebook_link'] = $single_data->facebook_link;
                $nestedData['document'] = $files;
                $nestedData['action']  = "$val&emsp;<a href=\"".route('admin.order_detail', ['order_id' => encrypt($single_data->id)])."\" class=\"btn btn-info btn-round\" target=\"_blank\">View Details</a>$delete";

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

    public function orderStatusUpdate($order_id, $status)
    {
    	try {
            $order_id = decrypt($order_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        try {
            $status = decrypt($status);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        DB::table('order')
        	->where('id', $order_id)
        	->update([
        		'order_status' => $status,
        		'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
        	]);

        $order = DB::table('order')
            ->where('id', $order_id)
            ->first();

        $subject = "Assam Products Order Confirmation";

        $data = [
            'message' => $order->order_id.' is accepted by Admin',
            'subject' => 'Order accept by Admin',
        ];

        Mail::to('pronabdasbaba5@gmail.com')->send(new OrderEmail($data));

        return redirect()->back();
    }

    public function orderDetail($order_id)
    {
        try {
            $order_id = decrypt($order_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $order = DB::table('order')
            ->where('id', $order_id)
            ->first();

        $user = DB::table('users')
            ->where('id', $order->user_id)
            ->first();

        $address = DB::table('address')
            ->where('id', $order->address_id)
            ->first();
            
        $order_detail = DB::table('order_detail')
            ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
            ->where('order_detail.product_type', 1)
            ->where('order_detail.order_id', $order_id)
            ->select('order_detail.*', 'product.product_name', 'product.slug', 'product.deleted_at')
            ->get();

        $data = [];

        if (!empty($order_detail) && (count($order_detail) > 0)) {

            foreach ($order_detail as $key => $item) {
                $data [] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'rate' => $item->price,
                    'discount' => $item->discount,
                    'product_type' => $item->product_type,
                    'slug' => $item->slug,
                    'deleted_at' => $item->deleted_at,
                ];
            }
        }

        $order_detail = DB::table('order_detail')
                ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                ->where('order_detail.product_type', 2)
                ->where('order_detail.order_id', $order_id)
                ->select('order_detail.*', 'product.product_name', 'product.slug', 'product.deleted_at')
                ->get();

        if (!empty($order_detail) && (count($order_detail) > 0)){

            foreach ($order_detail as $key => $item) {
                $data [] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'rate' => $item->price,
                    'discount' => $item->discount,
                    'product_type' => $item->product_type,
                    'slug' => $item->slug,
                    'deleted_at' => $item->deleted_at,
                ];
            }
        }

        $order_detail = DB::table('order_detail')
                ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                ->where('order_detail.product_type', 3)
                ->where('order_detail.order_id', $order_id)
                ->select('order_detail.*', 'product.product_name', 'product.slug', 'product.deleted_at')
                ->get();

        if (!empty($order_detail) && (count($order_detail) > 0)){

            foreach ($order_detail as $key => $item) {
                $data [] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'rate' => $item->price,
                    'discount' => $item->discount,
                    'product_type' => $item->product_type,
                    'slug' => $item->slug,
                    'deleted_at' => $item->deleted_at,
                ];
            }
        }

        $coupon = DB::table('coupon_user')
                ->leftJoin('coupon', 'coupon_user.coupon_id', '=', 'coupon.id')
                ->where('order_id', $order_id)
                ->select('coupon_user.*', 'coupon.coupon_code')
                ->first();

        return view('admin.orders.action.order_detail', ['order' => $order, 'user' => $user, 'address' => $address, 'order_detail' => $data, 'coupon' => $coupon]);
    }

    public function usersOrdersHistoryList($user_id)
    {
        try {
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_info = DB::table('users')
            ->where('id', $user_id)
            ->first();

        return  view('admin.orders.orders_history.orders_history', ['user_info' => $user_info]);
    }

    public function ordersHistoryListData(Request $request)
    {
        $columns = array( 
                            0 => 'id', 
                            2 => 'order_id',
                            3 => 'user_name',
                            4 => 'payment_id',
                            5 => 'payment_status',
                            6 => 'order_date',
                            7 => 'order_status',
                            8 => 'action',
                        );

        $totalData = DB::table('order')
            ->where('user_id', $request->input('user_id'))
            ->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {            
            
            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {

            $search = $request->input('search.value'); 

            $order_data = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('order')
                            ->leftJoin('users', 'order.user_id', '=', 'users.id')
                            ->select('order.*', 'users.name')
                            ->where('order.user_id', $request->input('user_id'))
                            ->orWhere('order.order_id','LIKE',"%{$search}%")
                            ->orWhere('users.name', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();

        if(!empty($order_data)) {

            $cnt = 1;

            foreach ($order_data as $single_data) {

                if($single_data->order_status == 1)
                    $val = "New Order";
                else if($single_data->order_status == 2)
                    $val = "Out for Delivery";
                else if($single_data->order_status == 4)
                    $val = "Canceled Order";
                else
                    $val = "Delivered Order";

                if (empty($single_data->payment_status)) 
                    $payment_status = "No Action";
                else 
                {
                    if($single_data->payment_status == 1)
                        $payment_status = "Failed";
                    else
                        $payment_status = "Paid";
                }

                $nestedData['id']             = $cnt;
                $nestedData['order_id']       = $single_data->order_id;
                $nestedData['user_name']      = "<a href=\"".route('admin.users_profile', ['user_id' => encrypt($single_data->user_id)])."\" title=\"View User Detail\" target=\"_blank\">$single_data->name</a>";
                $nestedData['payment_id']     = $single_data->payment_id;
                $nestedData['payment_status'] = $payment_status;
                $nestedData['order_date']     = \Carbon\Carbon::parse($single_data->created_at)->toDayDateTimeString();
                $nestedData['order_status']     = $val;
                $nestedData['action']  = "&emsp;<a href=\"".route('admin.order_detail', ['order_id' => encrypt($single_data->id)])."\" class=\"btn btn-info  btn-round\" target=\"_blank\">View Details</a>";

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

    public function deleteOrder($order_id)
    {
        DB::table('order')
            ->where('id', $order_id)
            ->delete();

        return redirect()->back();
    }
}
