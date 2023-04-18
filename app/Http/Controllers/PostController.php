<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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

        return view('post/post', [
            'data' => $data,
            'profil' => $profil,
        ]);
    
    }

    public function likes(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');
        $uuid_post = $request->input('uuid_post');
        $uuid_likes = uniqid();

        // insert to db
        DB::table('likes')->insert([
            'uuid' => $uuid_likes,
            'user' => $user_uuid,
            'post' => $uuid_post
        ]);
        // end insert

        return 'ok';
    }

    public function dislike(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');
        $uuid_post = $request->input('uuid_post');

        DB::table('likes')
            ->where('user', '=', $user_uuid)
            ->where('post', '=', $uuid_post)
            ->delete();
        // end delete

        return 'ok';
    }

    public function saved(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');
        $uuid_post = $request->input('uuid_post');
        $uuid_likes = uniqid();

        // insert to db
        DB::table('saved')->insert([
            'uuid' => $uuid_likes,
            'user' => $user_uuid,
            'post' => $uuid_post
        ]);
        // end insert

        return 'ok';
    }

    public function unsaved(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');
        $uuid_post = $request->input('uuid_post');

        DB::table('saved')
            ->where('user', '=', $user_uuid)
            ->where('post', '=', $uuid_post)
            ->delete();
        // end delete

        return 'ok';
    }

    public function delete(Request $request, $uuid_post)
    {
        $user_uuid = $request->session()->get('user_uuid');
       
        DB::table('post')
            ->where('user', $user_uuid)
            ->where('uuid', $uuid_post)
            ->update(['hapus' => 'hapus']);
        
        return redirect('/profile');
    }

    public function edit(Request $request, $uuid_post)
    {
        $user_uuid = $request->session()->get('user_uuid');
        
        // data querry
        $data = DB::table('post')
                ->where('uuid', '=', $uuid_post)
                ->where('user', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end data querry

        return view('post/edit', [
            'data' => $data
        ]);
    }

    public function edit_save(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        $caption = $request->input('caption');
        $post_uuid = $request->input('uuid');
        
        // update
        DB::table('post')
            ->where('user', $user_uuid)
            ->where('uuid', $post_uuid)
            ->update(['caption' => $caption]);
        // end update

        return redirect('/post_detail/'.$post_uuid);
    }
}
