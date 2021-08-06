<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        jQuery(function($){
            $('body').fadeIn(5000);
            $(window).on("beforeunload",function(e){
                $('body').fadeOut();
            });
        });
    </script>
</head>

<body>
    <div class="index">
        <h1 class="indextop">「いま」起きていることを見つけよう！！</h1>
    </div>
    <div class="button">
        <button type="button" class="btn" onclick="location.href='/pop'">始める</button>
    </div>
</body>

</html>