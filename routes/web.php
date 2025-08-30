<?php

use Illuminate\Support\Facades\Route;

Route::get('/test',[\App\Http\Controllers\testController::class, 'index']);
//login page
Route::get('/', function () {
    //return view('index.login');
    return view('modules.protocols');
});
// midelvare login
Route::get('/calculator', function () {
    return view('modules.calculator');
});
Route::get('/users_import', function () {
    return view('modules.users_import');
});
Route::get('/protocols', function () {
    return view('modules.protocols');
})->name('protocols.index');
Route::get('/protocol/{protocol_id}', [\App\Http\Controllers\ProtocolController::class, 'protokolList'])->name('protokol.list');
Route::get('/result/user_{user_id}/{protocol_id}', [\App\Http\Controllers\ProtocolController::class, 'userListIndividual'])->name('user.individual.list');
Route::post('/result/user', [\App\Http\Controllers\ProtocolController::class, 'enterDataUser'])->name('user.enter.data');
Route::post('/create-protocol', [\App\Http\Controllers\ProtocolController::class, 'createProtocol'])->name('createProtocol');
Route::get('/protocol/resul/{protocol_id}', [\App\Http\Controllers\ProtocolController::class, 'showResult'])
    ->name('show.protocol');
