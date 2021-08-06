<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AccountController extends Controller
{

    //ログイン
    public function Login(Request $request)
    {

        if (isset($request->mail) && isset($request->pass)) {

            $Result = DB::table('users')->where(['mail' => $request->mail, 'pass' => $request->pass])->first();
        }

        if (empty($Result)) {

            $messages['AccountNone'] = 'メールアドレスまたはパスワードが違います。';
        }

        if (empty($messages)) {
            Session::put('Result', $Result);

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

                //Log::debug($users->post_time);

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

        } else {

            return view('login')->with('message', $messages);
        }
    }

    //新規登録
    public function NewAccountInsert(Request $request)
    {
        $UserMail = DB::table('users')->where('mail', $request->mail)->value('mail');

        if (isset($UserMail) || $request->mail === " ") {
            $messages['Mail'] = 'このメールアドレスは使用できません。';
        }

        if (empty($request->mail) || empty($request->name) || empty($request->tel) || empty($request->pass) || empty($request->from) || empty($request->answer)) {

            $messages['Errors'] = '未入力の項目があります。';
        }

        if (isset($request->image)) {


            $path = $request->image->store('/public/images');
            $filename = basename($path);
        } else {

            $filename = NULL;
        }

        if (empty($messages)) {

            DB::table('users')->insertGetId(
                [
                    'user_image' => $filename, 'mail' => $request->mail, 'name' => $request->name, 'tel' => $request->tel, 'pass' => $request->pass, 'from' => $request->from, 'question_id' => $request->question, 'answer' => $request->answer, 'regret_id' => $request->regret
                ]
            );

            return view('login');
        } else {

            return view('account')->with('message', $messages);
        }
    }

    //仮のパスワード発行
    public function NewPassWordIssue(Request $request)
    {

        $user = DB::table('users')->where([
            'mail' => $request->mail, 'tel' => $request->tel, 'answer' => $request->answer
        ])->first();

        if (empty($user)) {
            $messages['AccountError'] = '入力内容に誤りがあります。';
        }

        if (empty($messages)) {

            DB::table('users')
                ->where('mail', $request->mail)
                ->update(['pass' => $request->tel]);

            $NewPassWord = DB::table('users')->where('mail', $request->mail)->value('pass');

            return view('newpassword')->with('NewPassWord', $NewPassWord);
        } else {

            return view('newpassword')->with('message', $messages);
        }
    }

    public function DeleteNewPassWordIssue(Request $request)
    {

        $user = DB::table('users')->where([
            'mail' => $request->mail, 'tel' => $request->tel, 'answer' => $request->answer
        ])->first();

        $SessionUser['mail']   = Session::get('Result')->mail;
        $SessionUser['tel']    = Session::get('Result')->tel;
        $SessionUser['answer'] = Session::get('Result')->answer;

        if (empty($user) || $user->mail !== $SessionUser['mail'] || $user->tel !== $SessionUser['tel'] || $user->answer !== $SessionUser['answer']) {
            $messages['AccountError'] = '入力内容に誤りがあります。';
        }

        if (empty($messages)) {

            DB::table('users')
                ->where('mail', $request->mail)
                ->update(['pass' => $request->tel]);

            $NewPassWord = DB::table('users')->where('mail', $request->mail)->value('pass');

            return view('DeleteNewPass')->with('NewPassWord', $NewPassWord);
        } else {

            return view('DeleteNewPass')->with('message', $messages);
        }
    }

    //アカウント情報の表示
    public function AccountView()
    {
        $SessionUser['image'] = Session::get('Result')->user_image;
        $SessionUser['mail']  = Session::get('Result')->mail;
        $SessionUser['name']  = Session::get('Result')->name;
        $SessionUser['tel']   = Session::get('Result')->tel;
        $SessionUser['pass']  = Session::get('Result')->pass;
        $SessionUser['from']  = Session::get('Result')->from;

        //Log::debug($SessionUser);

        if (isset($SessionUser)) {
            return view('accountUpdate')->with('SessionUser', $SessionUser);
        } else {
            return redirect('login');
        }
    }

    //アカウント情報の編集
    public function UpdateAccount(Request $request)
    {

        $UserName = Session::get('Result')->name;
        if (empty($request->mail) || empty($request->mail) || empty($request->name) || empty($request->tel) || empty($request->pass) || empty($request->from)) {

            $ERROR = '※未入力の項目があります。';

            $SessionUser['image'] = Session::get('Result')->user_image;
            $SessionUser['mail']  = Session::get('Result')->mail;
            $SessionUser['name']  = Session::get('Result')->name;
            $SessionUser['tel']   = Session::get('Result')->tel;
            $SessionUser['pass']  = Session::get('Result')->pass;
            $SessionUser['from']  = Session::get('Result')->from;
        }

        if (isset($request->image)) {

            $path = $request->image->store('/public/images');
            $filename = basename($path);
        } else {
            $filename = NULL;
        }

        if (empty($ERROR)) {

            DB::table('users')
                ->where('name', $UserName)
                ->update([
                    'user_image' => $filename,
                    'mail' => $request->mail,
                    'name' => $request->name,
                    'tel' => $request->tel,
                    'pass' => $request->pass,
                    'from' => $request->from,
                    'regret_id' => $request->regret
                ]);

            return view('login');
        } else {
            return view('accountUpdate')->with(['ERROR' => $ERROR, 'SessionUser' => $SessionUser]);
        }
    }
    //ログアウト
    public function Logout()
    {
        Session::forget('Result');

        $LogoutMessage = 'ログアウトしました。';
        return view('login')->with('LogoutMessage', $LogoutMessage);
    }

    //アカウント削除
    public function AccountDelete(Request $request)
    {
        $UserMail = Session::get('Result')->mail;
        $UserPass = Session::get('Result')->pass;

        $RequestMail = $request->mail;
        $RequestPass = $request->pass;

        if ($UserMail === $RequestMail && $UserPass === $RequestPass) {

            $Result = DB::table('users')->where(['mail' => $RequestMail, 'pass' => $RequestPass])->first();
        }

        if (empty($Result)) {

            $messages['AccountNone'] = 'メールアドレスまたはパスワードが違います。';
        }

        if (empty($messages)) {

            $UserId = Session::get('Result')->id;
            $PostId = DB::table('posts')->where('post_id', $UserId)->get(['id']);

            foreach ($PostId as $postid) {

                DB::table('comments')->where('post_id', $postid->id)->delete();
            }

            DB::table('users')->where('id', $UserId)->delete();
            DB::table('posts')->where('post_id', $UserId)->delete();
            DB::table('comments')->where('user_id', $UserId)->delete();

            $request->session()->forget('Result');

            $messages['AccountDelete'] = 'アカウントの削除が完了しました。';

            return view('login')->with('messages', $messages);
        } else {

            return view('accountDelete')->with('message', $messages);
        }
    }
}
