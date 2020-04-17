<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Owner;
use App\Buyer;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class admincontroller extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('verifyadmin');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllUsers()
    {
        $users = array();
        $users[] = Admin::paginate(10000);
        $users[] = Owner::paginate(10000);
        $users[] = Buyer::paginate(10000);
        return UserResource::collection($users);
    }
    public function createAdmin(Request $request)
    {   
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'username' => ['required', 'string', 'max:30', 'unique:' . 'buyer', 'unique:' . 'admin', 'unique:' . 'owner'],
            'password' => ['required', 'string', 'min:8'],
        ];

        $data = $request->all();
        $validated = Validator::make($data, $rules);
        if ($validated->fails()) return response("registeration failed", 400);
        $data['password'] = Hash::make($data['password']);
        $user = Admin::create($data); 
        return new UserResource($user);
    }

}
