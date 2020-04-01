<?php

namespace App;

use Illuminate\Notifications\Notifiable;

require_once 'User.php';

class Owner extends User
{
    use Notifiable;
    public $table = 'owner';
    protected $guard = 'owner';
}