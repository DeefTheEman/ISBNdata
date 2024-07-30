<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function verifyKey(Request $request) {
        $key = $request->input('loginkey');
        if (env('ACCESS_KEY') && $key === env('ACCESS_KEY')) {
            session(['access_granted' => true]);
            return redirect()->route('index');
        }
        else {
            return redirect()->back()->with('alert', 'Invalid access key');
        }
    }
}