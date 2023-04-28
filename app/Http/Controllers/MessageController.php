<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function message(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');

        $data = DB::select("
            SELECT DISTINCT dm.target, user.uuid, user.username, user.first_name, user.last_name, image
            FROM dm
            JOIN user ON dm.target = user.uuid
            WHERE dm.user = '${user_uuid}'
        ");
        
        return view('chat/message', [
            'data' => $data
        ]);
    }

    public function dm(Request $request, $uuid_target)
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

        $chat = DB::select("
            select * from dm 
            where (target='${uuid_target}' and user='${user_uuid}') 
            OR (user='${uuid_target}' and target='${user_uuid}')
        ");

        $target = DB::select("
            select * from user where uuid='${uuid_target}'
        ");

        // Update the "ts" values in the data array
        foreach ($chat as &$item) {
            $item->ts = timeDifference($item->ts);
        }
        
        // return $chat;
        return view('chat/dm', [
            'chat' => $chat,
            'target' => $target
        ]);
    }

    public function send_dm(Request $request)
    {
        $user_uuid = $request->session()->get('user_uuid');
        $uuid_target = $request->input('uuid_target');
        $isi_pesan = $request->input('isi_pesan');
        $uuid = uniqid();

        DB::table('dm')->insert([
            'uuid' => $uuid,
            'user' => $user_uuid,
            'target' => $uuid_target,
            'chat' => $isi_pesan
        ]);
        
        return back();
    }

    
      
}
