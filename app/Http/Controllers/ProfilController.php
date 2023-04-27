<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function profile(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // posts querry
        $posts = DB::table('post')
                ->whereNull('hapus')
                ->where('user', $user_uuid)
                ->orderBy('id', 'desc')
                ->get();
        // end posts querry

        // jumlah_post querry
        $jumlah_post = DB::table('post')
                        ->select(DB::raw('COUNT(*) as jumlah_post'))
                        ->whereNull('hapus')
                        ->where('user', $user_uuid)
                        ->first();
        // end jumlah_post querry

        // jumlah_following  querry
        $jumlah_following  = DB::table('following')
                            ->select(DB::raw('COUNT(*) as jumlah_following'))
                            ->where('user', $user_uuid)
                            ->first();
        // end jumlah_following  querry

        // jumlah_followers  querry
        $jumlah_followers  = DB::table('following')
                            ->select(DB::raw('COUNT(*) as jumlah_followers'))
                            ->where('following', $user_uuid)
                            ->first();
        // end jumlah_followers  querry

        // return $profil;
        return view('profil/profil', [
            'posts' => $posts,
            'profil' => $profil,
            'jumlah_post' => $jumlah_post,
            'jumlah_following' => $jumlah_following,
            'jumlah_followers' => $jumlah_followers
        ]);
    }
}
