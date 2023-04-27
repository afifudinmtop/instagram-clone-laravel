<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


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

    public function setting(Request $request) {
        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // return $profil;
        return view('profil/setting', [
            'profil' => $profil
        ]);
    }

    public function save_setting(Request $request) {
        $user_uuid = $request->session()->get('user_uuid');
        $bio = $request->input('bio');

        // kalau ada file
        if ($request->file('file')) {
            // compress then upload
            $filename = uniqid() . '.jpg';
            $img = Image::make($request->file('file'))->fit(370)->encode('jpg');
            Storage::put('public/uploads/' . $filename, $img);

            // save to database
            DB::table('user')
                ->where('uuid', $user_uuid)
                ->update(['image' => $filename, 'bio' => $bio]);
            // save to database end
        }

        // kalau tidak ada file
        else {
            // save to database
            DB::table('user')
                ->where('uuid', $user_uuid)
                ->update(['bio' => $bio]);
            // save to database end
        }

        return redirect('/profile/'); 
    }
}
