<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function post_detail(Request $request, $uuid_post)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // data querry
        $data = DB::table('post')
                    ->select('post.uuid', 'post.user', 'post.image', 'post.caption', 'post.ts',
                            DB::raw('MAX(user.username) as username'),
                            DB::raw('MAX(user.image) as user_image'),
                            DB::raw("IF(MAX(likes.post) IS NULL, 'love.png', 'lovex.png') AS likex"),
                            DB::raw("COUNT(DISTINCT likes.user) AS like_count"),
                            DB::raw("COUNT(DISTINCT comment.uuid) AS comment_count"),
                            DB::raw("IF(MAX(saved.post) IS NULL, 'saved.png', 'unsaved.png') AS saved_status"))
                    ->join('user', 'post.user', '=', 'user.uuid')
                    ->leftJoin('likes', 'post.uuid', '=', 'likes.post')
                    ->leftJoin('comment', 'post.uuid', '=', 'comment.post')
                    ->leftJoin('saved', 'post.uuid', '=', 'saved.post')
                    ->where('post.uuid', $uuid_post)
                    ->groupBy('post.uuid', 'post.user', 'post.image', 'post.caption', 'post.ts')
                    ->get();
        // end data querry

        return view('profil/post', [
            'data' => $data,
            'profil' => $profil,
        ]);
    
    }
}
