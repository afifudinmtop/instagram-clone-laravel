<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FeedController extends Controller
{
    public function feed(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');
        
        $list_post = DB::table('post')
                        ->select(
                            'post.uuid', 
                            'post.user', 
                            'post.image', 
                            'post.caption', 
                            'post.ts', 
                            'user.username', 
                            'user.image as user_image', 
                            DB::raw("IF(likes.post IS NULL, 'love.png', 'lovex.png') AS likex"),
                            DB::raw("IF(saved.post IS NULL, 'saved.png', 'unsaved.png') AS saved_status"),
                            DB::raw("COALESCE(num_likes.num_likes, 0) AS num_likes"),
                            DB::raw("COALESCE(num_comments.num_comments, 0) AS num_comments")
                        )
                        ->join('user', 'post.user', '=', 'user.uuid')
                        ->leftJoin('likes', function($join) use ($user_uuid){
                            $join->on('post.uuid', '=', 'likes.post')
                                ->where('likes.user', '=', $user_uuid);
                        })
                        ->leftJoin('saved', function($join) use ($user_uuid){
                            $join->on('post.uuid', '=', 'saved.post')
                                ->where('saved.user', '=', $user_uuid);
                        })
                        ->join('following', 'following.following', '=', 'post.user')
                        ->where('following.user', '=', $user_uuid)
                        ->leftJoin(DB::raw('(SELECT post, COUNT(*) AS num_likes FROM likes GROUP BY post) num_likes'), 'post.uuid', '=', 'num_likes.post')
                        ->leftJoin(DB::raw('(SELECT post, COUNT(*) AS num_comments FROM comment GROUP BY post) num_comments'), 'post.uuid', '=', 'num_comments.post')
                        ->whereNull('post.hapus')
                        ->orderByDesc('post.id')
                        ->get();

        // end sql list_post

        // find on db
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();

        return view('feed/feed', [
            'list_post' => $list_post,
            'profil' => $profil,
        ]);
        return $profil;
    }
}
