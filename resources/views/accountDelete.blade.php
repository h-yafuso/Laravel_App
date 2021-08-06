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
        <div>
            <button type="button" class="returnBtn" onclick="location.href='/cancel'">⇦戻る</button>
        </div>
        <h1 class="checkouttitle">退会</h1>
        <div class="texts">
            <div>
                <p class="DeleteAlert">※退会するとユーザー情報、過去の投稿はすべて削除されます。</p>
            </div>
            <div>
                @if (isset($message['AccountNone']))
                <span class="errors">{{ $message['AccountNone'] }}</span>
                @endif
            </div>
            <form action="accountDelete" method="post">
                {{ csrf_field() }}
                <div>
                    <input type="text" class="deletemail" name="mail" placeholder="メールアドレス" size="40"><br>
                    <input type="password" class="deletepass" name="pass" placeholder="パスワード" size="40"><br>
                </div>
                <div>
                    <button type="button" class="DeletePassHelp" onclick="location.href='/DeleteNewPass'">パスワードをお忘れですか？</button>
                </div>
                <div>
                    <input type="submit" class="accountDelete" value="退会">
                </div>
            </form>
        </div>
</body>

</html>