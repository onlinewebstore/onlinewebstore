<?php

namespace App;

use Illuminate\Notifications\Notifiable;

require_once 'User.php';

class Buyer extends User
{
    public $table = 'buyer';
    use Notifiable;
    protected $guard = 'buyer';
}