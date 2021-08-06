<!DOCTYPE html>
<html lang="ja">

<head>
    <title>新しいパスワード取得画面</title>
    <link rel="stylesheet" href="{{ asset('css/newpassword.css') }}">
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

<body>
    <div class="box">
        <div>
            <button type="button" class="returnBtn" onclick="location.href='/logindisplay'">⇦キャンセル</button>
        </div>
        <h3 class="newpasstitle">仮のIDとパスワードを作成します。</h3>
        <form action="newPassword" method="post">
            {{ csrf_field() }}
            <div class="QuestionError">
                @if (isset($message['AccountError']))
                <span class="errors">{{ $message['AccountError'] }}</span>
                @endif
            </div>
            <div class="NewPassBtn">
                <input type="text" class="questionmail" name="mail" placeholder="メールアドレス" 　size="40">
            </div>
            <div>
                <input type="text" class="questiontel" name="tel" placeholder="電話番号" 　size="40">
            </div>
            <div>
                <input type="text" class="questionanswer" name="answer" placeholder="質問の答え" size="40">
            </div>
            <div>
                <input type="submit" class="NewPassPush" value="送信">
                <input type="button" class="NewPassReturn" onclick="location.href='/logindisplay'" value="ログイン画面">
            </div>
        </form>
        @if (isset($NewPassWord))
        <p class="newpass">あなたのパスワード:<span class="NewPass">{{ $NewPassWord }}</span></p>
        @endif
    </div>
</body>

</html>