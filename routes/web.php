<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/getBook', [BookController::class, 'getBook'])->name('getbook');
Route::get('/editBook', [BookController::class, 'editBook'])->name('editbook');
Route::get('/removeErr', [BookController::class, 'removeErr'])->name('removeErr');