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
}
