<?php

// use App\Http\Controllers\BookController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckAccesKey;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/verifyKey', [LoginController::class, 'verifyKey'])->name('verifyKey');
Route::get('/removeErr', [ErrorController::class, 'removeErr'])->name('removeErr');

Route::middleware('checkKey')->group(function (){
    Route::get('/', function () {
        return view('search');
    })->name('index');
    // Route::get('/search', function () {
    //     $timeTaken = session('timeTaken');
    //     $searchresults = session('searchresults');
    //     return view('search')->with(compact('searchresults', 'timeTaken'));
    // })->name('search');
    Route::get('/getBook', [EditController::class, 'getBook'])->name('getbook');    
    Route::get('/editBook', [EditController::class, 'editBook'])->name('editbook');
    Route::get('/getSearch', [EditController::class, 'getSearch'])->name('getSearch');
});

// Route::get('/back', function () {
//     return redirect()->back();
// })->name('back');