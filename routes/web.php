<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [BookController::class, 'controllerFunc']);
// Route::get('/update', 'BookController@update')->name('updateroute');
Route::get('/update', [BookController::class, 'update'])->name('updateroute');