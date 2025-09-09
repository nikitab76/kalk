<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersNew extends Model
{
    protected $fillable = ['name', 'login', 'password'];
}
