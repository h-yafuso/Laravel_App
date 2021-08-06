<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Refresh" content="4;URL=/logindisplay">
    <title>ログアウト</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
    <div id="center">
        <div>
            さぁ、始めよう！！
        </div>
    </div>
</body>

</html>