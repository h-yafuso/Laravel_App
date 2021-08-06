<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/mypost.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
</head>

<body>
    <div>
        <button type="button" class="returnBtn" onclick="location.href='/cancel'">⇦メイン画面へ戻る</button>
    </div>
    @if (isset($message['DataNone']))
    <table class="list">
        <tr>
            <td colspan="2">
                <div class="DataError">
                    <p><span class="DataNoneError">{{ $message['DataNone'] }}</span></p>
                </div>
            </td>
        </tr>
    </table>
    @endif
    @if (isset($users))
    @foreach($users as $user)
    <table class="list">
        <tr>
            <td colspan="2" class="PostUserImage">
                @if(isset($user->user_image))
                <img src="{{ asset('storage/images/' . $user->user_image) }}" class="img">
                @endif
                <span class="name">{{ $user->name }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="postday">{{ $user->post_time }}</td>
        </tr>
        <tr>
            @if(isset($user->post_image))
            <td><img src="{{ asset('storage/images/' . $user->post_image) }}" class="postImg" border="4"></td>
            @endif
        </tr>
        <tr>
            <td class="userpost">{{ $user->post }}</td>
        </tr>
        <tr>
            <td>
                <form action="postDelete" method="post">
                    {{ csrf_field() }}
                    <input type="submit" class="deletebtn" value="削除">
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <button type="button" class="updatebtn postUpdate-modal-open" value="{{$user->id}}">編集</button>
                </form>
            </td>
        </tr>
        <tr>
            <td class="commenttitlename">コメント</td>
        </tr>
        @if (isset($user->comment))
        @foreach($user->comment as $CommentUser)
        <tr>
            <td colspan="2" class="commenttitle">
                @if(isset($CommentUser->user_image))
                <img src="{{ asset('storage/images/' . $CommentUser->user_image) }}" class="commentUserimg">
                @endif
                <span class="CommentUserName">{{ $CommentUser->name }}</span><span class="commentday">{{ $CommentUser->comment_time }}</span>
            </td>
        </tr>
        <tr>
            <td class="commenttext">{{ $CommentUser->comment }}</td>
        </tr>
        <tr>
            <td>
                <form action="commentDelete" method="post">
                    {{ csrf_field() }}
                    <input type="submit" class="deletebtn" value="削除">
                    <input type="hidden" name="id" value="{{$CommentUser->id}}">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    @endforeach
    @endif
    <div class="postsbody postUpdate-modal">
        <button type="button" class="postUpdate-modal-close">✖</button>
        <h2 class="posts_h2">投稿内容編集</h2>
        <form action="postUpdate" method="post">
            {{ csrf_field() }}
            <div class="posts">
                <div class="postarea">
                    <textarea name="post" id="userpost" class="post" cols="40" rows="8"></textarea>
                </div>
                <div class="post-buttons">
                    <input type="submit" class="postpush" value="編集">
                    <input type="hidden" id="userid" name="id" value="">
                </div>
            </div>
        </form>
    </div>
</body>

</html>