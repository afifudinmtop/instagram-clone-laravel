<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function register_save(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'username' => ['required', 'min:3', 'max:20'],
            'password' => ['required','min:3', 'max:20'],
            'first_name' => ['required','min:3', 'max:20'],
            'last_name' => ['required','min:3', 'max:20']
        ]);

        // assign
        $uuid = uniqid();
        $username = $request->input('username');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $password = Hash::make($request->input('password'));

        // cek user exist
        $exist = DB::table('user')
                ->where('username', '=', $username)
                ->limit(1)
                ->count();
                
        // user already exist
        if ($exist) {
            return back()->with('error', 'user already exist!');
        }

        // insert to db
        DB::table('user')->insert([
            'uuid' => $uuid,
            'username' => $username,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'image' => 'default.png'
        ]);

        // redirect with success message
        return back()->with('success', 'created account successfully!');
    }

    public function login()
    {
        return view('home/login');
    }

    public function login_save(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'username' => ['required', 'min:3', 'max:20'],
            'password' => ['required','min:3', 'max:20']
        ]);

        // assign
        $username = $request->input('username');
        $password = $request->input('password');

        // cek on db
        $exist = DB::table('user')
                ->where('username', '=', $username)
                ->limit(1)
                ->count();

        // find on db
        $user = DB::table('user')
                ->where('username', '=', $username)
                ->limit(1)
                ->get();

        // wrong username
        if (!$exist) {
            return back()->with('error', 'invalid username/password!');
        }
        
        // wrong username
        if (!Hash::check($password, $user[0]->password)) {
            return back()->with('error', 'invalid username/password!');
        }

        // store data session
        $request->session()->put('user_uuid', $user[0]->uuid);

        // all good
        return redirect('/feedx');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login/');
    }
}
