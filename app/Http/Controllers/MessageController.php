<?php

namespace App\Http\Controllers;

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
        $user_uuid = $request->session()->get('user_uuid');

        $chat = DB::select("
            select * from dm 
            where (target='${uuid_target}' and user='${user_uuid}') 
            OR (user='${uuid_target}' and target='${user_uuid}')
        ");

        $target = DB::select("
            select * from user where uuid='${uuid_target}'
        ");
        
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
