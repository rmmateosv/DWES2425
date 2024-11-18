<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return view('holaMundo');
});

Route::get('/alumnos', function () {
     return 'Bienvenido Alumnos';
});

Route::get('/alumnos', function () {
    return 'Bienvenido Alumnos';
});
Route::get('/alumnos/{nombre}', function ($nombreA) {
    return 'Bienvenido '.$nombreA;
});
Route::get('/alumnos/insertar/{nombre}', function ($nombreA) {
    return 'Página para crear alumno '.$nombreA;
});