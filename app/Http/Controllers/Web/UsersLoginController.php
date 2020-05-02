<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Hash;
use DB;
use Carbon\Carbon;
use App\Mail\ForgotPassEmail;
use Mail;

class UsersLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:users')->except('logout');
    }

    public function showUserLoginForm(){

        $header_color = DB::table('header_section')->first();

        return view('web.login', ['url' => 'users', 'header_color' => $header_color]);
    }

    public function userLogin(Request $request){

        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if ((Auth::guard('users')->attempt(['email' => $request->username, 'password' => $request->password, 'verification' => 0, 'status' => 1])) || (Auth::guard('users')->attempt(['contact_no' => $request->username, 'password' => $request->password, 'verification' => 0, 'status' => 1]))) {

            /** If Cart is Present **/
            if (Session::has('cart') && !empty(Session::get('cart'))) {
                $cart = Session::get('cart');

                if (count($cart) > 0) {

                    foreach ($cart as $product_id => $item) {

                        if (!empty($product_id)) {
                            $product_type = explode(',', $item);
                            $quantity = current($product_type);
                            $product_type = end($product_type);

                            $check_cart_product = DB::table('cart')
                                ->where('user_id', Auth::guard('users')->user()->id)
                                ->where('product_id', $product_id)
                                ->count();

                            if ($check_cart_product < 1 ) {

                                DB::table('cart')
                                    ->insert([
                                        'user_id' => Auth::guard('users')->user()->id,
                                        'product_id' =>  $product_id,
                                        'product_type' =>  (int)$product_type,
                                        'quantity' => (int)$quantity,
                                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                                    ]);
                            }
                        }
                    }
                }
                Session::forget('cart');
                Session::save();
            }
            
            return redirect()->intended('/');
        }
        return back()->withInput($request->only('username'))->with('login_error','Username or password incorrect or You are not verfied or You account is deactivated');
    }

    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->route('web.login');
    }

    public function showForgotPasswordForm()
    {
        return view('web.forgot-pass');
    }

    public function verficationCode(Request $request)
    {
        $request->validate([
            'username' => 'required'
        ],[
            'username.required' => 'Email or Mobile is required'
        ]);

        $user = DB::table('users')
            ->where('email', $request->input('username'))
            ->orWhere('contact_no', $request->input('username'))
            ->first();

        if (empty($user)) 
            return redirect()->back()->with('msg', 'You not a registered user');
        else {

            $subject = "Forgot Password";
            $title = "Verification Code";
            $rand = rand(100000, 999999);

            $data = [
                'message' => $rand.' verification code for forgot password.',
                'subject' => $subject,
                'title' => $title,
            ];

            Mail::to($user->email)->send(new ForgotPassEmail($data));

            sendSMS($user->contact_no, $rand.' verification code for forgot password.');

            $user_cnt = DB::table('reset_password')
                ->where('user_id', $user->id)
                ->count();

            if ($user_cnt > 0) {
                DB::table('reset_password')
                    ->where('user_id', $user->id)
                    ->update([
                        'code' => $rand
                    ]);
            } else {

                DB::table('reset_password')
                    ->insert([
                        'user_id' => $user->id,
                        'code' => $rand
                    ]);
            }

            return redirect()->route('web.set_pass_form', ['user_id' => $user->id]);
        }
    }

    public function showSetPasswordForm($user_id)
    {
        return view('web.set_password', ['user_id' => $user_id]);
    }

    public function setPassword(Request $request, $user_id) 
    {
        $validatedData = $request->validate([
            'verification_code' => 'required|numeric',
            'password' => ['required', 'string', 'same:confirm_password'],
        ]);

        $check_verification = DB::table('reset_password')
            ->where('user_id', $user_id)
            ->where('code', $request->input('verification_code'))
            ->count();

        if ($check_verification > 0) {

            DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'password' => Hash::make($request->input('password')),
                    'original_password' => $request->input('password'),
                ]);

            DB::table('reset_password')
                ->where('user_id', $user_id)
                ->delete();

            return redirect()->back()->with('msg', 'Password has been set successfully.');

        } else 
            return redirect()->back()->with('error', 'Invalid Code');
    }
}
