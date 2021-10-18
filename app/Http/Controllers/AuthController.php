<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UsersModel;
use Validator;
use Session;
use Auth;
use DB;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('auth.login');
    }

    public function sendLogin(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ],  [
            'required' => ':attribute is required',
        ]);

        if ($validator->fails()) {
            $errors = $this->parseValidator($validator);
            Session::put('flash_message','Failed create new record because '.$errors);
            return redirect()->route('login');
        }
        
        $data = $validator->validated();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('');
        }else{
            Session::put('flash_message','Invalid email and password combination');
            return redirect()->route('login');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
