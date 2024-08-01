<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function removeErr(Request $request) {
        session()->forget('alert');
        return redirect()->back();
    }
}
