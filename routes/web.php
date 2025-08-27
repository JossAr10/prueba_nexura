<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('empleados', EmpleadoController::class);

Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');

