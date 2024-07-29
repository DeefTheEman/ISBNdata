<?php

// use App\Http\Controllers\BookController;
use App\Http\Controllers\EditController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/getBook', [EditController::class, 'getBook'])->name('getbook');    
Route::get('/editBook', [EditController::class, 'editBook'])->name('editbook');
Route::get('/removeErr', [EditController::class, 'removeErr'])->name('removeErr');
Route::get('/search', [EditController::class, 'search'])->name('search');

// Route::get('/back', function () {
//     return redirect()->back();
// })->name('back');