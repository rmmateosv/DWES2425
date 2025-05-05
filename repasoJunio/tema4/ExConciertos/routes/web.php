<?php

use App\Http\Controllers\ConciertoC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('rI');
});

Route::controller(ConciertoC::class)->group(
    function (){
        Route::get('inicio','inicioM')->name('rI');
        Route::get('entradas/{idConcierto}','entradasM')->name('rE');
        Route::post('entradas/{idConcierto}','venderM')->name('rV');
        Route::delete('concierto/{idConcierto}','borrarM')->name('rB');
    }
);
