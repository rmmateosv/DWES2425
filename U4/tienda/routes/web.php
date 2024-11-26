<?php

use App\Http\Controllers\LoginC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/inicio', function () {
    return 'Página de inicio de usuarios logueados';
})->name('inicio');

Route::controller(LoginC::class)->group(
    function(){
        Route::get('login', 'vistaLogin')->name('vistaLogin');
        Route::post('login', 'loguear')->name('loguear');
        Route::get('registrar', 'vistaRegistro')->name('vistaRegistro');
        Route::post('registrar', 'registrar')->name('registrar');
        Route::get('cerrar', 'cerrarSesion')->name('cerrar');
    }
);

