<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function dashboard()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return view('home');
        }

        return view('auth.verify');
    }

    /**
     * Show the public home page of the site
     *
     * @return Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('dashboard');
        }

        return view('public.welcome');
    }
}
