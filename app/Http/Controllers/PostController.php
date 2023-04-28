<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function post_detail(Request $request, $uuid_post)
    {
        function timeDifference($timestamp) {
            $now = Carbon::now();
            $targetTime = Carbon::parse($timestamp)->subHours(7); // Subtract 7 hours from the timestamp
          
            $diff = $now->diff($targetTime);
          
            $seconds = $diff->s;
            $minutes = $diff->i;
            $hours = $diff->h;
            $days = $diff->d;
            $weeks = floor($days / 7);
          
            if ($weeks > 0) {
              return $weeks . " week" . ($weeks == 1 ? "" : "s") . " ago";
            } elseif ($days > 0) {
              return $days . " day" . ($days == 1 ? "" : "s") . " ago";
            } elseif ($hours > 0) {
              return $hours . " hour" . ($hours == 1 ? "" : "s") . " ago";
            } elseif ($minutes > 0) {
              return $minutes . " minute" . ($minutes == 1 ? "" : "s") . " ago";
            } else {
              return $seconds . " second" . ($seconds == 1 ? "" : "s") . " ago";
            }
        }

        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                ->where('uuid', '=', $user_uuid)
                ->limit(1)
                ->get();
        // end profil querry

        // data querry
        $data = DB::select("SELECT post.uuid, post.user, post.image, post.caption, post.ts, user.username, user.image AS user_image, comment_count.comment_count, likes_count.likes_count,
         CASE WHEN likes_user.user IS NOT NULL THEN 'lovex.png' ELSE 'love.png' END AS likex,
          CASE WHEN saved_user.user IS NOT NULL THEN 'unsaved.png' ELSE 'saved.png' END AS saved_status
        FROM post
        JOIN user ON post.user = user.uuid
        LEFT JOIN (
          SELECT post, COUNT(*) AS comment_count
          FROM comment
          GROUP BY post
        ) AS comment_count ON post.uuid = comment_count.post
        LEFT JOIN (
          SELECT post, COUNT(*) AS likes_count
          FROM likes
          GROUP BY post
        ) AS likes_count ON post.uuid = likes_count.post
        LEFT JOIN (
          SELECT post, user
          FROM likes
          WHERE user = '$user_uuid'
        ) AS likes_user ON post.uuid = likes_user.post
        LEFT JOIN (
          SELECT post, user
          FROM saved
          WHERE user = '$user_uuid'
        ) AS saved_user ON post.uuid = saved_user.post
        WHERE post.uuid = '$uuid_post'");

        // end data querry

        // Update the "ts" values in the data array
        foreach ($data as &$item) {
            $item->ts = timeDifference($item->ts);
        }

        // return $data;
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

    public function list_like(Request $request, $uuid_post)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                    ->where('uuid', '=', $user_uuid)
                    ->limit(1)
                    ->get();
        // end profil querry

        // list_like querry
        $list_like = DB::table('likes')
                    ->join('user', 'likes.user', '=', 'user.uuid')
                    ->select('likes.post', 'likes.user', 'user.username', 'user.image', 'user.first_name', 'user.last_name')
                    ->where('likes.post', '=', $uuid_post)
                    ->get();
        // end list_like querry

        return view('post/list_like', [
            'list_like' => $list_like,
            'profil' => $profil,
        ]);
    
    }

    public function list_comment(Request $request, $uuid_post)
    {
        $user_uuid = $request->session()->get('user_uuid');

        // profil querry
        $profil = DB::table('user')
                    ->where('uuid', '=', $user_uuid)
                    ->limit(1)
                    ->get();
        // end profil querry

        // list_like querry
        $list_comment = DB::table('comment')
                            ->select('comment.uuid', 'comment.user', 'comment.post', 'comment.comment', 'comment.ts', 'user.username', 'user.image')
                            ->join('user', 'comment.user', '=', 'user.uuid')
                            ->where('comment.post', '=', $uuid_post)
                            ->whereNull('comment.hapus')
                            ->get();
        // end list_comment querry

        // post querry
        $post = DB::table('post')
                    ->join('user', 'post.user', '=', 'user.uuid')
                    ->select('post.uuid', 'post.user', 'post.image', 'post.caption', 'post.ts', 'user.username', 'user.image as user_image')
                    ->where('post.uuid', $uuid_post)
                    ->get();
        // end post querry

        // return $list_comment;
        return view('post/list_comment', [
            'list_comment' => $list_comment,
            'profil' => $profil,
            'post' => $post
        ]);
    
    }

    public function comment_save(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        $uuid_post = $request->input('uuid_post');
        $comment = $request->input('comment');
        $uuid_comment = uniqid();
        
        // insert to db
        DB::table('comment')->insert([
            'uuid' => $uuid_comment,
            'user' => $user_uuid,
            'post' => $uuid_post,
            'comment' => $comment
        ]);
        // end insert

        return redirect('/post_detail/'.$uuid_post);
    }

    public function delete_comment(Request $request, $uuid_comment)
    {
        $user_uuid = $request->session()->get('user_uuid');
     
        DB::table('comment')
            ->where('user', $user_uuid)
            ->where('uuid', $uuid_comment)
            ->update(['hapus' => 'hapus']);
        
        return back();
    }
}
