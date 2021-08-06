<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>アカウント編集画面</title>
    <link rel="stylesheet" href="{{ asset('css/accountUpdate.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        jQuery(function($) {
            $('body').fadeIn(3000);
            $(window).on("beforeunload", function(e) {
                $('body').fadeOut();
            });
        });
    </script>
</head>

<body class="AccountUpdatebody">
    <div class="box">
        <div>
            <h1 class="accountupdatetitle_h1">アカウントの編集</h1>
            <h3 class="accountupdatetitle_h3">項目の内容を編集して「完了」ボタンを押してください。</h3>
        </div>
        <div>
            @if(isset($ERROR))
            <p class="errors">{{$ERROR}}</p>
            @endif
        </div>
        <form action="updateAccount" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                <input type="file" class="ComfirmImage" name="image" value="{{$SessionUser['image']}}">
            </div>
            <div class="Comfirms">
                <div>
                    <input type="text" class="ComfirmMail" name="mail" placeholder="{{'メールアドレス：'. $SessionUser['mail']}}" size="40">
                </div>
                <div>
                    <input type="text" class="ComfirmName" name="name" placeholder="{{'名前またはニックネーム：' . $SessionUser['name']}}" size="40">
                </div>
                <div>
                    <input type="text" class="ComfirmTel" name="tel" placeholder="{{'電話番号：' . $SessionUser['tel']}}" size="40">
                </div>
                <div>
                    <input type="password" class="ComfirmPass" name="pass" placeholder="{{'パスワード：' . $SessionUser['pass']}}" size="40">
                </div>
                <div>
                    <input type="text" class="ComfirmFrom" name="from" placeholder="{{'所在地：' . $SessionUser['from']}}" size="40">
                </div>
                <div>
                    <select class="ComfirmRegret" name="regret">
                        <option value="1">公開</option>
                        <option value="2">友達のみ</option>
                    </select>
                </div>
            </div>
            <div class="buttons">
                <input type="submit" class="UpdatePush" name="newaccount" value="完了">
                <input type="button" class="UpdateReturn" onclick="location.href='/cancel'" value="キャンセル">
            </div>
        </form>
    </div>
</body>

</html>