<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>コメント画面</title>
    <link rel="stylesheet" href="{{ asset('css/mainstyle.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
</head>

<body>
    <div class="commentbody">
        <h2 class="comments_h2">コメント</h2>
        <form action="/newComment" method="post">
            {{ csrf_field() }}
            <div class="coments">
                @if (isset($message['message']))
                <span class="errors">{{ $message['message'] }}</span>
                @endif
                <textarea name="text" class="comment" cols="40" rows="8" placeholder="コメントを入力してください。"></textarea><br>
                <input type="submit" class="commentpush" 　name="btn" value="コメント">
                <input type="hidden" name="id" value="{{$id}}">
                <input type="button" class="commentreturn" onclick="location.href='/cancel'" value="キャンセル">
            </div>
        </form>
    </div>
</body>

</html>