<?php

namespace App\Http\Controllers;

use App\Models\UserResultProtokol;
use App\Models\UsersNew;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function index()
    {
        UsersNew::create([
            'name' => 'admin',
            'login' => 'admin',
            'password' => 'admin'
        ]);
        session()->forget('admin');
        dd(2);
        $r = UserResultProtokol::query()->find(1);
        $w = json_decode($r->normative, true);
        $w['прыжок'] = 25;
        // Если нужно сохранить обратно в модель
        $r->normative = json_encode($w, JSON_UNESCAPED_UNICODE);
        $r->save();
        dd($w);
    }

    public function login(Request $request)
    {
        if (UsersNew::query()->where('login', $request->login)->first()){
            session()->put('admin', 1);
            return view('modules.protocols');
        }
        return view('index.login');
    }
}
