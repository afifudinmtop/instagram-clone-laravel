<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function landing()
    {
        return view('home/landing');
    }

    public function register()
    {
        return view('home/register');
    }
}
