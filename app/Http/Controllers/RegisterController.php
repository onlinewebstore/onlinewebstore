<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Owner;
use App\Admin;
use App\Buyer;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('checklogin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'username' => ['required', 'string', 'max:30', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request, $type)
    {
        
        $data = $request->all();
        $validated = $this->validator($data);
        if ($validated->fails()) return response("registeration failed", 400);
        $data['password'] = Hash::make($data['password']);
        if($type == 'buyer') $user = Buyer::create($data); 
        else if($type == 'owner') $user = Owner::create($data);
        return new UserResource($user);
    }
}