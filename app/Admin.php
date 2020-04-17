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
    
}
