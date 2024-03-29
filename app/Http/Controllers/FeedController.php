<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    public function feed(Request $request)
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
        // find on db end

        // Update the "ts" values in the data array
        foreach ($list_post as &$item) {
            $item->ts = timeDifference($item->ts);
        }
        
        return view('feed/feed', [
            'list_post' => $list_post,
            'profil' => $profil,
        ]);
    }

    public function add_post(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');

        // compress then upload
        $filename = uniqid() . '.jpg';
        $img = Image::make($request->file('file'))->fit(370)->encode('jpg');
        Storage::put('public/uploads/' . $filename, $img);

        return redirect('/add')->with('image', $filename);
    }

    public function add()
    {
        return view('feed/add');
    }

    public function add_save(Request $request)
    {
        // assign
        $user_uuid = $request->session()->get('user_uuid');
        $caption = $request->input('caption');
        $image = $request->input('image');
        $uuid_post = uniqid();

        // insert to db
        DB::table('post')->insert([
            'uuid' => $uuid_post,
            'user' => $user_uuid,
            'image' => $image,
            'caption' => $caption
        ]);
        // end insert

        return redirect('/post_detail/'.$uuid_post);
    }
}
