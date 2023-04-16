<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LogisterController extends Controller
{
    public function index () {
        $locale = request()->cookie('locale', config('app.locale'));
        session(['locale' => $locale]);
        app()->setLocale($locale);
        return view('login', ['user_info'=> auth()->user()]);
    }

    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],
        [
            'email.required' => 'Please, enter your email address',
            'email.email' => 'Please, enter a valid email addres',
            'password.required' => 'Please, enter your password'
        ]);
        if (auth()->attempt(request()->only(['email', 'password']), $request->remember == 'on')) {
            return redirect('/home');
        }
        else {
            return redirect()->back()->withErrors([
                'email' => 'Wrong email or password'
            ]);
        }
    }

    public function logout () {
        auth()->logout();

        return redirect('/home');
    }
}
