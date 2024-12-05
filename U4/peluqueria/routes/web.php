<?php

use App\Http\Controllers\CitaC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(CitaC::class)->group(
    function(){
        Route::get('citas','verCitas')->name('verCitas');
        Route::put('citas/{id}','modificarCita')->name('modificarC');
        Route::delete('citas/{id}','borrarCita')->name('borrarC');
        Route::post('citas','crearCita')->name('crearC');
        Route::get('detalle/{id}','crearDetalle')->name('crearDetalle');
    }
);
