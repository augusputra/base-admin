<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UsersModel;
use Validator;
use Session;
use DB;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('auth.login');
    }

    public function sendLogin(Request $request){
        $rules = 
            ['email' => 'required',
             'password' => 'required'];
        $validator = Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) 
        {
            Session::put('flash_message',$validator->errors()->all());
            return redirect()->route('login');
        }else{
            $user = UsersModel::with('role')->where('email', $request->email)->first();
            if($user){
                if($user->role->name == 'admin'){
                    if(Hash::check($request->password, $user->password)){
                        Session::put('auth', $user);
                        return redirect()->route('admin.dashboard');
                    }else{
                        Session::put('flash_message','Only admin can access the next page');
                        return redirect()->route('login');
                    }
                }else{
                    Session::put('flash_message','Invalid password combination');
                    return redirect()->route('login');
                }
            }else{
                Session::put('flash_message','Please check the email you entered');
                return redirect()->route('login');
            }
        }
    }
}
