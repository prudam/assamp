<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use DB;
use Hash;
use App\Mail\OrderEmail;
use Mail;

class RegisterController extends Controller
{
    public function registration(Request $request) {

    	if ($request->input('user_role') == 1) {
    		$validatedData = $request->validate([
	            'user_role' => 'required',
	            'name' => ['required', 'string', 'max:255'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'same:confirm_password'],
	            'contact_no' =>  ['required','digits:10','numeric','unique:users'],
			],
			[
				'contact_no.required' => 'Contact no. should be of 10 digits'
			]);
    	} else if ($request->input('user_role') == 2){
    		$validatedData = $request->validate([
	            'user_role' => 'required',
	            'name' => ['required', 'string', 'max:255'],
	            'gst_no' => 'required|min:15|max:15',
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'same:confirm_password'],
	            'contact_no' =>  ['required','digits:10','numeric','unique:users'],
			],
			[
				'contact_no.required' => 'Contact no. should be of 10 digits'
			]);
    	} else {
    		$validatedData = $request->validate([
	            'user_role' => 'required',
	            'name' => ['required', 'string', 'max:255'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'same:confirm_password'],
	            'contact_no' =>  ['required','digits:10','numeric','unique:users'],
			],
			[
				'contact_no.required' => 'Contact no. should be of 10 digits'
			]);
    	}

    	if ($request->input('user_role') == 1) {

    		$user = User::create([
	            'name' => $request->input('name'),
	            'email' => $request->input('email'),
	            'contact_no' => $request->input('contact_no'),
	            'gst_no' => $request->input('gst_no'),
	            'user_role' => $request->input('user_role'),
	            'gender' => $request->input('gender'),
	            'verification' => 0,
	            'status' => 1,
	            'password' =>  Hash::make($request->input('password')),
	            'original_password' =>  $request->input('password'),
	        ]);
    	} else {

    		$user = User::create([
	            'name' => $request->input('name'),
	            'email' => $request->input('email'),
	            'contact_no' => $request->input('contact_no'),
	            'gst_no' => $request->input('gst_no'),
	            'user_role' => $request->input('user_role'),
	            'gender' => $request->input('gender'),
	            'verification' => 1,
	            'status' => 0,
	            'password' =>  Hash::make($request->input('password')),
	            'original_password' =>  $request->input('password'),
	        ]);

	        sendSMS('9706028611', "One new seller has been registered. Please Check.");
	        
	        $subject = "Seller Registration";

            $data_1 = [
                'message' => "One new seller has been registered. Please Check.",
                'subject' => $subject,
            ];

            Mail::to('eaglegroup.assam@gmail.com')->send(new OrderEmail($data_1));
    	}

        if ($user) {

        	if ($request->input('user_role') == 1)
        		return redirect()->back()->with('msg','Your account has been open successfully.');
        	else
        		return redirect()->back()->with('msg','Your account will be activated after approval of the administrator. Please call 6001800448 / 6913334671');
        }
        else
            return redirect()->back()->with('msg','Something Went Wrong Please Try Again');
    }

    public function registrationPage() {
    	
    	return view('web.register');
    }
}
