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

    public function user(Request $request, $uuid_user) {
        $user_uuid = $request->session()->get('user_uuid');

        // kalau profil sendiri
        if ($user_uuid == $uuid_user) {
            return redirect('/profile/');
        }

        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // user querry
        $user = DB::table('user')
                ->where('uuid', '=', $uuid_user)
                ->limit(1)
                ->get();
        // end user querry

        // posts querry
        $posts = DB::table('post')
                ->whereNull('hapus')
                ->where('user', $uuid_user)
                ->orderBy('id', 'desc')
                ->get();
        // end posts querry

        // jumlah_post querry
        $jumlah_post = DB::table('post')
                        ->select(DB::raw('COUNT(*) as jumlah_post'))
                        ->whereNull('hapus')
                        ->where('user', $uuid_user)
                        ->first();
        // end jumlah_post querry

        // jumlah_following  querry
        $jumlah_following  = DB::table('following')
                            ->select(DB::raw('COUNT(*) as jumlah_following'))
                            ->where('user', $uuid_user)
                            ->first();
        // end jumlah_following  querry

        // jumlah_followers querry
        $jumlah_followers  = DB::table('following')
                            ->select(DB::raw('COUNT(*) as jumlah_followers'))
                            ->where('following', $uuid_user)
                            ->first();
        // end jumlah_followers querry

        // follow querry
        $follow = DB::table('following')
                ->select(DB::raw('COUNT(*) as jumlah'))
                ->where('user', $user_uuid)
                ->where('following', $uuid_user)
                ->first();
        // end follow querry

        // return $follow;
        return view('profil/user', [
            'follow' => $follow,
            'posts' => $posts,
            'user' => $user,
            'profil' => $profil,
            'jumlah_post' => $jumlah_post,
            'jumlah_following' => $jumlah_following,
            'jumlah_followers' => $jumlah_followers
        ]);
    }

    public function follow(Request $request, $uuid_user) {
        $user_uuid = $request->session()->get('user_uuid');
        $uuid = uniqid();

        DB::table('following')->insert([
            'uuid' => $uuid,
            'user' => $user_uuid,
            'following' => $uuid_user,
        ]);

        return back();
    }

    public function unfollow(Request $request, $uuid_user) {
        $user_uuid = $request->session()->get('user_uuid');

        // delete db
        DB::table('following')
            ->where('user', $user_uuid)
            ->where('following', $uuid_user)
            ->delete();
        // delete db end

        return back();
    }

    public function user_following(Request $request, $uuid_user) {
        $user_uuid = $request->session()->get('user_uuid');
       
        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // list_following querry
        $list_following = DB::table('following')
                            ->select('following.following', 'user.username', 'user.image', 'user.first_name', 'user.last_name')
                            ->join('user', 'following.following', '=', 'user.uuid')
                            ->where('following.user', $uuid_user)
                            ->get();
        // end list_following querry

        // return $list_following;
        return view('profil/user_following', [
            'list_following' => $list_following,
            'profil' => $profil
        ]);
    }

    public function user_followers(Request $request, $uuid_user) {
        $user_uuid = $request->session()->get('user_uuid');
       
        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // list_followers querry
        $list_followers = DB::table('following')
                            ->select('following.user', 'user.username', 'user.image', 'user.first_name', 'user.last_name')
                            ->join('user', 'following.user', '=', 'user.uuid')
                            ->where('following.following', $uuid_user)
                            ->get();
        // end list_followers querry

        // return $list_followers;
        return view('profil/user_followers', [
            'list_followers' => $list_followers,
            'profil' => $profil
        ]);
    }
}
