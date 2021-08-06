<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
    <link rel="stylesheet" href="{{ asset('css/newaccount.css') }}">
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
        <h1 class="accounttitle">ソーシャルネットワークを始めよう</h1>
        <form action="newAccount" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                @if (isset($message['Mail']))
                <span class="errors">{{ $message['Mail'] }}</span><br>
                @endif
                @if (isset($message['Errors']))
                <span class="errors">{{ $message['Errors'] }}</span>
                @endif
            </div>
            <p><input type="file" class="Newimage" name="image"></p>
            <p><input type="text" class="Newmail" name="mail" placeholder="メールアドレス" size="40"></p>
            <p><input type="text" class="Newname" name="name" placeholder="名前またはニックネーム" size="40"></p>
            <p><input type="text" class="Newtel" name="tel" placeholder="電話番号　ハイフンは省く" size="40"></p>
            <p><input type="password" class="Newpass" name="pass" placeholder="パスワード" size="40"></p>
            <p><input type="text" class="Newfrom" name="from" placeholder="所在地" size="40"></p>
            <div>
                <select class="Newquestion" name="question">
                    <option value="1">ペットの名前は？</option>
                    <option value="2">趣味は？</option>
                    <option value="3">出身は？</option>
                    <option value="4">何人家族？</option>
                </select>
            </div>
            <div>
                <input type="text" class="Newanswer" name="answer" placeholder="質問の答え" size="40"><br>
                @if (isset($message['Answer']))
                <span class="errors">{{ $message['Answer'] }}</span>
                @endif
            </div>
            <div>
                <select class="Newregret" name="regret">
                    <option value="1">公開</option>
                    <option value="2">友達のみ</option>
                </select>
            </div>
            <div>
                <input type="submit" class="Newsubmit" value="アカウント作成">
            </div>
            <div>
                <input type="button" class="Newsubmitcancel" onclick="location.href='/logindisplay'" value="キャンセル">
            </div>
        </form>
    </div>
</body>

</html>