<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->roles == 'superadmin') {
                Session::flash('success', 'Selamat Datang');
                return redirect('/superadmin');
            } else {
                Session::flash('success', 'Selamat Datang');
                return 'role lain';
            }
        }
        return view('login');
    }
    public function login(Request $req)
    {
        // if ($req->get('cf-turnstile-response') == null) {
        //     Session::flash('warning', 'Checklist Captcha');
        //     return back();
        // } else {
        //     $turnstile = new TurnstileLaravel;
        //     $response = $turnstile->validate($req->get('cf-turnstile-response'));

        //     if ($response['status'] == true) {

        $remember = $req->remember ? true : false;
        $credential = $req->only('username', 'password');

        if (Auth::attempt($credential, $remember)) {

            if (Auth::user()->roles == 'superadmin') {
                Session::flash('success', 'Selamat Datang');
                return redirect('/superadmin');
            } else {
                Session::flash('success', 'Selamat Datang');
                return 'role lain';
            }
        } else {

            Session::flash('error', 'username/password salah');
            $req->flash();
            return back();
        }
        //         }
        //     }
    }
}
