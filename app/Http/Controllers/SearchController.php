<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search_feed(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // posts querry
        $posts = DB::table('post')
                    ->whereNull('hapus')
                    ->inRandomOrder()
                    ->get();
        // end posts querry

        // profil querry
        $profil = DB::table('user')
                    ->where('uuid', '=', $user_uuid)
                    ->limit(1)
                    ->get();
        // end profil querry
        
        return view('search/feed', [
            'posts' => $posts,
            'profil' => $profil,
        ]);
    
    }

    public function search(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // list_user querry
        $list_user = DB::table('user')
                    ->whereNull('hapus')
                    ->get();
        // end list_user querry

        // profil querry
        $profil = DB::table('user')
                    ->where('uuid', '=', $user_uuid)
                    ->limit(1)
                    ->get();
        // end profil querry
        
        // return $list_user;

        return view('search/search', [
            'list_user' => $list_user,
            'profil' => $profil,
        ]);
    
    }

    public function search_post(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');
        $cari_value = $request->input('cari_value');

        // list_user querry
        $list_user = DB::table('user')
                        ->where(function($query) use ($cari_value) {
                            $query->where('username', 'LIKE', '%' . $cari_value . '%')
                                    ->orWhere('first_name', 'LIKE', '%' . $cari_value . '%')
                                    ->orWhere('last_name', 'LIKE', '%' . $cari_value . '%');
                        })
                        ->whereNull('hapus')
                        ->get();
        // end list_user querry

        return $list_user;
    }
}
