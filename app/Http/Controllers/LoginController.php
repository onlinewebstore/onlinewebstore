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
    }
    public function datavalidate($data)
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

        $data = json_decode($request->getContent(), true);

        $validator = $this->datavalidate($data);
        if ($validator=="") {
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed"));
        } else {
            foreach ($typeofusers as $type) {
                if ($validator=="email"&&Auth::guard($type)->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Login Succesful"));
                    return;
                } else if ($validator=="username"&&Auth::guard($type)->attempt(['username' => $data['username'], 'password' => $data['password']])) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Login Succesful"));
                    return;
                }
            }
            http_response_code(400);
            echo json_encode(array("message" => "Login failed"));
        }
    }
    /*public function buyerLogin(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],

        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            //echo 'testing';
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed"));
        } else {
            if (Auth::guard('buyer')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                http_response_code(200);
                echo json_encode(array("message" => "Login Succesful"));
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Login failed"));
            }
        }
    }
    public function adminLogin(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],

        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            //echo 'testing';
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed"));
        } else {

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                http_response_code(200);
                echo json_encode(array("message" => "Login Succesful"));
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Login failed"));
            }
        }
    }
    public function ownerLogin(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],

        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            //echo 'testing';
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed"));
        } else {

            if (Auth::guard('owner')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                http_response_code(200);
                echo json_encode(array("message" => "Login Succesful"));
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Login failed"));
            }
        }
    }*/
    function logout()
    {
        Auth::guard('buyer')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('owner')->logout();
    }
    function test()
    {
        $user = Auth::guard('admin')->user();
        print_r($user->type);
    }
}
