<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Admin;
use App\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        //$this->middleware('guest:admin');
        $this->middleware('guest:owner');
        $this->middleware('guest:buyer');
    }
    protected function createAdmin(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $user->createAdmin($request);
    }
    public function validatedata($data){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'username' => ['required', 'string', 'max:30', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'password' => ['required', 'string', 'min:8'],
        ];
        $validator =Validator::make($data, $rules);
        if($validator->fails()){
            return false;
        }
        return true;
    }
    public function create($type, $data)
    {
        $userdata = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ];
        if ($type == 'owner') {
            Owner::create($userdata);
        } elseif ($type == 'buyer') {
            Buyer::create($userdata);
        }
        http_response_code(200);
        echo json_encode(array("message" => "Registeration Successful"));
    }
    protected function createOwner(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validated = $this->validatedata($data);
        if (!$validated) {
            http_response_code(400);
            echo json_encode(array("message" => "Owner Registeration failed"));
        } else {
            $this->create('owner', $data);
        }
    }
    protected function createBuyer(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validated = $this->validatedata($data);
        if (!$validated) {
            http_response_code(400);
            echo json_encode(array("message" => "Buyer Registeration failed"));
        } else {
            $this->create('owner', $data);
        }
    }
}
