<?php

use App\Http\Controllers\CitaController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('citas', [CitaController::class,'index'] );
Route::post('citas', [CitaController::class,'store'] )->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('detalleCita', [CitaController::class,'detalleCita'] );
