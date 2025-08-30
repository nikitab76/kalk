<?php

namespace App\Http\Controllers;

use App\Models\UserResultProtokol;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function index()
    {
        $r = UserResultProtokol::query()->find(1);
        $w = json_decode($r->normative, true);
        $w['прыжок'] = 25;
        // Если нужно сохранить обратно в модель
        $r->normative = json_encode($w, JSON_UNESCAPED_UNICODE);
        $r->save();
        dd($w);
    }
}
