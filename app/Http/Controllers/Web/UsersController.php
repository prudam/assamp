<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class UsersController extends Controller
{
    public function showUserRegisterForm()
    {
        return view('web.user.register', ['url' => 'users']);
    }

    protected function createUser(Request $request)
    {
        
    	$user_cnt = DB::table('users')
    		->where('contact_no', $request['mobile_no'])
    		->count();

    	if ($user_cnt > 0) 
    		return redirect()->back()->with('msg', 'You have already registered.');

        $user = User::create([
            'name' => ucwords(strtolower($request['name'])),
            'email' => $request['email'],
            'contact_no' => $request['mobile_no'],
            'password' => Hash::make($request['pass']),
        ]);

        return redirect()->intended('login');
    }

    public function myProfile()
    {
        $my_account = DB::table('users')
            ->where('id', Auth()->user()->id)
            ->first();

        return view('web.user.my_profile', ['my_account' => $my_account]);
    }

    public function updateMyProfile(Request $request)
    {
        $mobile_no_cnt = DB::table('users')
            ->where('contact_no', $request->input('mobile_no'))
            ->where('id', '!=', Auth()->user()->id)
            ->count();

        if ($mobile_no_cnt > 0)
            return redirect()->back()->with('msg', 'Mobile already used. Try Another');
        else
        {
            DB::table('users')
                ->where('id', Auth()->user()->id)
                ->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'contact_no' => $request->input('mobile_no')
                ]);

            return redirect()->back()->with('msg', 'Account has been updated');
        }
    }
}
