<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUser;

Route::get('main', function () {
    //
})->middleware(CheckUser::class);

Route::get('accountUpdate', function () {
    //
})->middleware(CheckUser::class);

Route::get('/pop', function () {
    return view('pop');
});
Route::get('/', function () {
    return view('index');
});
Route::get('/logindisplay', function () {
    return view('login');
});
Route::get('/account', function () {
    return view('account');
});
Route::get('/newpassword', function () {
    return view('newpassword');
});

Route::get('/accountDelete', function () {
    return view('accountDelete');
});
Route::get('/DeleteNewPass', function () {
    return view('DeleteNewPass');
});

Route::get('/accountView', 'AccountController@AccountView');

//ログイン
Route::get('/login', 'AccountController@Login');
//ログアウト
Route::get('/logout', 'AccountController@Logout');
//アカウント新規登録
Route::post('/newAccount', 'AccountController@NewAccountInsert');
//仮パスワード発行
Route::post('/newPassword', 'AccountController@NewPassWordIssue');
Route::post('/DeleteNewPass', 'AccountController@DeleteNewPassWordIssue');
//アカウント情報編集
Route::post('/updateAccount', 'AccountController@UpdateAccount');
//アカウント削除
Route::post('/accountDelete', 'AccountController@AccountDelete');


//友達申請
Route::post('/friendApplication{id}', 'FriendController@FriendApplication');


//新規投稿
Route::post('/newPost', 'PostController@NewPosting');
//投稿の削除
Route::post('/postDelete', 'PostController@PostDelete');
//投稿の編集
Route::post('/postUpdate', 'PostController@PostUpdate');
//投稿履歴閲覧
Route::get('/myPosts', 'PostController@MyPostView');



//新規コメント
Route::post('/newComment', 'CommentController@NewComment');
//コメント削除
Route::post('/commentDelete', 'CommentController@CommentDelete');

//キーワード検索
Route::get('/KeyWordSearch', 'PostController@KeyWordSearch');

Route::get('/cancel', 'PostController@Canseler');
