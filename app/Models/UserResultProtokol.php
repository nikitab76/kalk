<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserResultProtokol extends Model
{
    protected $fillable = ['user', 'user_id', 'district', 'birthday', 'sex', 'name_protokol', 'normative'];
    //
}
