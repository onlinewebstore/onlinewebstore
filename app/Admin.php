<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
require_once 'User.php';

class Admin extends User
{
    use Notifiable;
    public $table = 'admin';
    protected $guard = 'admin';
    public function createAdmin(Request $request)
    {   
        $data = json_decode($request->getContent(), true);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'username' => ['required', 'string', 'max:30', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'password' => ['required', 'string', 'min:8'],
        ];
    
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            http_response_code(400);
            echo json_encode(array("message" => "Admin Registeration failed"));
        } else {
            $admin = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
            ]);
            http_response_code(200);
            echo json_encode(array("message" => "Admin Registeration Succesful"));
            
        }
        
    }

    public function getallusers(){
        $buyers = Buyer::all();
        $owners = Owner::all();
        $admins = Admin::all();
        $data = array();
        foreach ($buyers as $user) {
            $data[] = $user;
        }
        foreach ($owners as $user) {
            $data[] = $user;
        }
        foreach ($admins as $user) {
            $data[] = $user;
        }
        echo json_encode($data);
    }
}
