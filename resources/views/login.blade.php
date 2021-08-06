<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script>
        jQuery(function($) {
            $('body').fadeIn(3000);
            $(window).on("beforeunload", function(e) {
                $('body').fadeOut();
            });
        });
    </script>
</head>

<body>
    <div class="box">
    <h1 class="logintop">ログイン</h1>
        <form action="login" method="get">
            <div>
                @if (isset($message['AccountNone']))
                <span class="errors">{{ $message['AccountNone'] }}</span>
                @endif
            </div>
            <div>
                @if (isset($messages['AccountDelete']))
                <span class="DeleteAlert">{{ $messages['AccountDelete'] }}</span>
                @endif
            </div>
            <div>
                @if (isset($LogoutMessage))
                <span class="DeleteAlert">{{ $LogoutMessage }}</span>
                @endif
            </div>
            <div>
                <input type="text" class="loginmail" name="mail" placeholder="メールアドレス" size="40">
            </div>
            <div>
                <input type="password" class="loginpass" name="pass" placeholder="パスワード" size="40" value="">
            </div>
            <div>
                <button type="button" class="new" onclick="location.href='/account'">新規登録</button>
                <button type="button" class="passhelp" onclick="location.href='/newpassword'">パスワードをお忘れですか？</button>
            </div>
            <div>
                <input type="submit" class="login" name="login" value="ログイン">
            </div>
        </form>
    </div>
</body>

</html>