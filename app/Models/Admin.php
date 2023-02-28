<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $fillable = ['name', 'email', 'password', 'type', 'status', 'mobile', 'image']; // To handle Mass Assignment
    protected $hidden = ['password', 'remember_token']; // Sometimes you may wish to limit the attributes, such as passwords, that are included in your model's array or JSON representation.
}
