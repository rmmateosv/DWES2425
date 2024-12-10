<?php

use App\Http\Controllers\LoginC;
use App\Http\Controllers\ProductosC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('inicio');
});

Route::controller(ProductosC::class)->group(
    function(){
        Route::get('inicio', 'verProductos')->name('inicio');
        Route::post('crear','crearP')->name('crearP');
        Route::get('modificar/{idP}','vistaModificar')->name('vistaModificar');
        Route::put('modificar/{idP}','modificarP')->name('modificarP');
        Route::delete('borrar/{idP}','borrarP')->name('borrarP');
    }
);
Route::controller(LoginC::class)->group(
    function(){
        Route::get('login', 'login')->name('login');
        Route::post('login', 'loguear')->name('loguear');
        Route::get('usuarios', 'vistaUsuarios')->name('vistaUsuarios')->middleware('auth');
        Route::post('usuarios/crear','crearU')->name('crearU')->middleware('auth');
        Route::delete('usuarios/borrar/{idU}','borrarU')->name('borrarU')->middleware('auth');
        Route::get('cerrar', 'cerrar')->name('cerrar')->middleware('auth');;
    }
);
