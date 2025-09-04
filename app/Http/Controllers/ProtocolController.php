<?php

namespace App\Http\Controllers;

use App\Models\ProtokolName;
use App\Models\UserResultProtokol;
use Cassandra\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class ProtocolController extends Controller
{
    public function createProtocol(Request $request)
    {

        if(!isset($request->protocol_name))
            return 'name none';
        if (ProtokolName::where('name', $request->protocol_name)->exists())
            return 'this name exists';

        $name_protokol = isset($request->protocol_name) ? md5($request->protocol_name) : 'name none';
        ProtokolName::create(['name' => $request->protocol_name, 'name_id' => md5($request->protocol_name), 'date' => $request->date]);

        $file = $request->file('users_group');
        $rows = (new FastExcel)->import($file);

        foreach ($rows as $row) {
            $systemFields = ['ФИО', 'Район', 'пол', 'Дата рождения', 'Ступень'];

            $user = !empty($row['ФИО']) ? $row['ФИО'] : 'b|n';
            $district = !empty($row['Район']) ? $row['Район'] : 'nb';
            $birthdayRaw = !empty($row['Дата рождения']) ? $row['Дата рождения'] : 'no dr';
            $sex = !empty($row['пол']) ? $row['пол'] : 'trans';

            if ($birthdayRaw instanceof \DateTimeInterface) {
                // если объект даты, форматируем в строку Y-m-d
                $birthday = $birthdayRaw->format('Y-m-d');
            } elseif (is_string($birthdayRaw)) {
                // если строка, пытаемся преобразовать
                $birthday = date('Y-m-d', strtotime($birthdayRaw));
            } else {
                // если нет данных или не подходит, ставим null или дефолт
                $birthday = null; // или '0000-00-00' если надо
            }

            $normatives = [];

            foreach ($row as $key => $value) {
                if (!in_array($key, $systemFields)) {
                    if ($key != "")
                        $normatives[$key] = $value;
                }
            }
            UserResultProtokol::create(
                [
                    'user' => $user,
                    'user_id' => md5($user),
                    'district' => $district,
                    'birthday' => $birthday,
                    'sex' => $sex,
                    'name_protokol' => $name_protokol,
                    'normative' => json_encode($normatives),
                ]
            );
        }
        return view('modules.protocols');
    }

    public function protokolList($protocol_id)
    {
        $list = UserResultProtokol::query()->where('name_protokol', $protocol_id) ->orderBy('user', 'asc')
            ->pluck('user', 'user_id')->toArray();
        return view('modules.protokolList', compact(['list', 'protocol_id']));
    }

    public function userListIndividual($userId, $protocol_id)
    {
        $user = UserResultProtokol::query()->where('user_id', $userId)->where('name_protokol', $protocol_id)->first();
        $normative = json_decode($user->normative, true);
        return view('modules.userResult', compact(['userId', 'normative', 'protocol_id']));
    }

    public function enterDataUser (Request $request)
    {
        //dd($request->value);
        $key = 'normative->' . $request->normative;
        $user = UserResultProtokol::query()->where('user_id', $request->user)
            ->where('name_protokol', $request->protocol)
            ->update([$key => $request->value]);
        return 1;

    }

    public function showResult($protocol_id)
    {
        $protokol = UserResultProtokol::query()->where('name_protokol', $protocol_id)->get();
        $data = [];
        foreach ($protokol as $user) {
            $row['user'] = $user->user;
            $row['district'] = $user->district;
            foreach (json_decode($user->normative, true) as $key => $normativ) {
                $row[$key] = $normativ;
            }
            $data[] = $row;
        }
        return view('modules.prtokolShow', compact(['protocol_id', 'data']));
    }
}
