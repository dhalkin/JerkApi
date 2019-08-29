<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('home');
    }

    /**
     * Show the studios.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function studios()
    {
        return view('studios');
    }

    /**
     * Show profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userprofile()
    {
        return view('profile');
    }

    /**
     * Show profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function branches()
    {
        return view('branches');
    }

    /**
     * Show profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function trainers()
    {
        return view('trainers');
    }
}
