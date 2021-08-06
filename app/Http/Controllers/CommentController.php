<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function NewComment(Request $request)
    {

        if (isset($request->text)) {

            $Name = Session::get('Result')->name;

            $CommentUser_id = DB::table('users')->where('name', $Name)->value('id');
            $dt = Carbon::now();
            $commentTime = $dt->year . '年' . $dt->month . '月' . $dt->day .'日'. ' ' . $dt->hour .':'. $dt->minute;

            DB::table('comments')->insertGetId(
                [
                    'user_id' => $CommentUser_id, 'post_id' => $request->id, 'comment_day' => date('Y/m/d'), 'comment_time' => $commentTime, 'comment' => $request->text
                ]
            );
        }

        $users = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.post_id')
            ->select(
                'posts.id',
                'users.user_image',
                'users.name',
                'posts.post_day',
                'posts.post_time',
                'posts.post_image',
                'posts.post',
                'posts.good'
            )->orderBy('id', 'desc')
            ->get();

        foreach ($users as $User) {

            $comment_user = DB::table('comments')
                ->where('comments.post_id', $User->id)
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->join('posts', 'posts.id', '=', 'comments.post_id')
                ->select(
                    'users.user_image',
                    'users.name',
                    'comments.id',
                    'comments.comment_day',
                    'comments.comment_time',
                    'comments.comment'
                )->orderBy('id', 'desc')
                ->get();

            $User->comment = $comment_user;
        }

        $request->session()->regenerateToken();

        return view('main')->with('users', $users);
    }

    public function CommentDelete(Request $request)
    {

        $user_name = Session::get('Result')->name;
        DB::table('comments')->where('id', $request->id)->delete();

        $users = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.post_id')
            ->where('name', $user_name)
            ->select(
                'posts.id',
                'users.user_image',
                'users.name',
                'posts.post_day',
                'posts.post_time',
                'posts.post_image',
                'posts.post',
                'posts.good'
            )->orderBy('id', 'desc')
            ->get();

        foreach ($users as $User) {

            $comment_user = DB::table('comments')
                ->where('comments.post_id', $User->id)
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->join('posts', 'posts.id', '=', 'comments.post_id')
                ->select(
                    'users.user_image',
                    'users.name',
                    'comments.id',
                    'comments.comment_day',
                    'comments.comment_time',
                    'comments.comment'
                )->orderBy('id', 'desc')
                ->get();

            $User->comment = $comment_user;
        }
        return view('myPosts')->with('users', $users);
    }
}
