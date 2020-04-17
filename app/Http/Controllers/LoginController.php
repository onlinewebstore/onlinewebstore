<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('checklogin')->except('logout');
    }
    public function validator($data)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
        $rules2 = [
            'username' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8'],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $validator = Validator::make($data, $rules2);
            if ($validator->fails()) {
                return "";
            } else {
                return "username";
            }
        } else {
            return "email";
        }
    }
    public function login(Request $request)
    {
        $typeofusers = array('admin', 'owner', 'buyer');

        //  $data = json_decode($request->getContent(), true);
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator == "") {
            abort(400, 'validation failed');
        } else {
            foreach ($typeofusers as $type) {
                if ($validator == "email" && Auth::guard($type)->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    return response('Login Successful', 200);
                } else if ($validator == "username" && Auth::guard($type)->attempt(['username' => $data['username'], 'password' => $data['password']])) {
                    return response('Login Successful', 200);
                }
            }
            abort(400, 'User not found.');
        }
    }
    function logout()
    {
        Auth::guard('buyer')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('owner')->logout();
    }
    function test()
    {
        $user = Auth::guard('buyer')->user();
        print_r($user->type);
    }
}
