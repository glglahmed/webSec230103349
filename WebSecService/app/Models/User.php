<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'admin',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}