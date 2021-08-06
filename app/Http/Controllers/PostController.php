<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class PostController extends Controller
{
    //キーワード検索
    public function KeyWordSearch(Request $request)
    {

        if (isset($request->NameWord)) {

            $users = DB::table('users')
                ->join('posts', 'users.id', '=', 'posts.post_id')
                ->where('name', 'like', "%$request->NameWord%")
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

        }

        Log::debug($users);

        if (empty($request->NameWord) || empty($users)) {

            $messages['DataNone'] = '"' . "$request->NameWord" . '"' . 'の検索結果はありませんでした。';

            return view('main')->with('message', $messages);
        }

        if (empty($messages)) {

            return view('main')->with('users', $users);
        }
    }


    //投稿
    public function NewPosting(Request $request)
    {
        if (isset($request->image)) {

            $path = $request->image->store('/public/images');
            $filename = basename($path);
        } else {

            $filename = NULL;
        }

        if (isset($request->text)) {

            $user_id = Session::get('Result')->id;

            $dt = Carbon::now();
            $postTime = $dt->year . '-' . $dt->month . '-' . $dt->day . '' . ' ' . $dt->hour . ':' . $dt->minute;

            DB::table('posts')->insert(
                [
                    'post_id' => $user_id, 'post_day' => date('Y/m/d'), 'post_time' => $postTime, 'post' => $request->text, 'post_image' => $filename, 'good' => 0
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

    public function Canseler()
    {
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

        return view('main')->with('users', $users);
    }

    //投稿履歴の表示
    public function MyPostView()
    {
        $user_id = Session::get('Result')->id;
        $user_name = Session::get('Result')->name;

        $UserPost = DB::table('posts')->where('post_id', $user_id)->value('id');

        if (!empty($UserPost)) {
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

        if (empty($users)) {

            $messages['DataNone'] = '現在投稿はありません。';

            Log::debug($messages['DataNone']);

            return view('myPosts')->with('message', $messages);
        }
    }

    //投稿の削除
    public function PostDelete(Request $request)
    {
        $user_name = Session::get('Result')->name;
        $user_post = Session::get('Result')->id;

        DB::table('posts')->where('id', $request->id)->delete();
        DB::table('comments')->where('post_id', $request->id)->delete();

        $UserPost = DB::table('posts')->where('post_id', $user_post)->value('id');

        if (empty($UserPost)) {

            $messages['DataNone'] = '現在投稿はありません。';

            return view('myPosts')->with('message', $messages);
        }

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

    //投稿記事編集
    public function PostUpdate(Request $request)
    {
        $user_name = Session::get('Result')->name;

        DB::table('posts')
            ->where('id', $request->id)
            ->update(['post' => $request->post]);


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
