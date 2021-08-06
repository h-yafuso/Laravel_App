<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>投稿ページ</title>
    <link rel="stylesheet" href="{{ asset('css/mainstyle.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        jQuery(function($){
            $('body').fadeIn(3000);
            $(window).on("beforeunload",function(e){
                $('body').fadeOut();
            });
        });
    </script>
</head>

<body>
    <div class="postsbody">
        <h2 class="posts_h2">投稿</h2>
        <form action="newPost" method="post">
            {{ csrf_field() }}
            <div class="posts">
                <div>
                    <button type="button" name="image" class="imgbtn">画像を追加する</button>
                </div>
                <div>
                    <textarea name="text" class="post" cols="40" rows="8" placeholder="投稿内容を入力してください。"></textarea>
                </div>
                <div>
                    <input type="submit" class="postpush" 　name="#" value="投稿する">
                    <input type="button" class="postreturn" onclick="location.href='/cancel'" value="キャンセル">
                </div>
            </div>
        </form>
    </div>
</body>

</html>