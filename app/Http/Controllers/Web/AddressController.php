<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class AddressController extends Controller
{
    public function addAddress(Request $request)
    {
    	$request->validate([
            'name'    => 'required',
            'email' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'pin_code' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        DB::table('address')
        	->insert([
        		'user_id' => Auth()->user()->id,
                'name'    => $request->input('name'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'mobile_no' => $request->input('contact_no'),
                'pin_code' => $request->input('pin_code'),
	            'city' => $request->input('city'),
	            'state' => $request->input('state'),
        	]);

        return redirect()->back();
    }

    public function deleteAddress($address_id) 
    {
        DB::table('address')
            ->where('id', $address_id)
            ->update([
                'status' => 2
            ]);

        return redirect()->back();
    }
}
