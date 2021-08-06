<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メイン画面</title>
    <link rel="stylesheet" href="{{ asset('css/mainstyle.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script rel=" stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
    <hedder>
        <div class="hedder">
            <div class="SiteName">
                <h2 class="SocialMate">SocialMate</h2>
            </div>
            <div class="MainButtons">
                <button type="button" class="postbtn post-modal-open">投稿</button>
                <button type="button" class="serchbtn keyword-modal-open">検索</button>
                <button type="button" class="Accountbtn Account-modal-open">設定</button>
                <button type="button" class="logoutbtn" onclick="location.href='logout'">退出</button>
            </div>
        </div>
    </hedder>
    <div class="Serchbody keyword-modal">
        <button type="button" class="keyword-modal-close">✖</button>
        <form action="KeyWordSearch" method="get">
            <div class="NameSerch">
                <input type="text" class="keyword" name="NameWord" placeholder="🔎お名前検索" size="40">
            </div>
            <div class="keyword-serch">
                <input type="submit" class="keyword-serch-btn" value="検索">
            </div>
        </form>
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
                <button type="button" class=" commentbtn comment-modal-open" value="{{$user->id}}">コメントする</button>
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
                <span class="CommentUserName">{{ $CommentUser->name }}</span>
            </td>
        </tr>
        <tr>
            <td class="commenttext">{{ $CommentUser->comment }}</td>
        </tr>
        <tr>
            <td><span class="commentday">{{ $CommentUser->comment_time }}</span></td>
        </tr>
        <tr>
            <td class="bottomline"></td>
        </tr>
        @endforeach
        @endif
    </table>
    @endforeach
    @endif
    <footer>
        <div class="footer">
            <marquee scrollamount="10" behavior="scroll" class="news">
                <?php
                // タイムゾーンを日本に設定
                date_default_timezone_set('Asia/Tokyo');

                // 取得したいRSSのURLを設定
                $url = "https://news.yahoo.co.jp/rss/topics/science.xml";
                // MAXの表示件数を設定
                $max = 15;

                // simplexml_load_file()でRSSをパースしてオブジェクトを取得、オブジェクトが空でなければブロック内を処理
                if ($rss = simplexml_load_file($url)) {
                    $cnt = 0;
                    $output = '';
                    /*
                    * $item->title：タイトル
                    * $item->link：リンク
                    * strtotime( $item->pubDate )：更新日時のUNIX TIMESTAMP
                    * $item->description：詳細
                    */
                    // item毎に処理
                    foreach ($rss->channel->item as $item) {
                        // MAXの表示件数を超えたら終了
                        if ($cnt >= $max) break;

                        // 日付の表記の設定
                        $date = date('Y年m月d', strtotime($item->pubDate));
                        // 出力する文字列を用意
                        $output .= '<a class=\'yahoo\' href="' . $item->link . '">' . $date . " " . "[" . $item->title . "]" . "　" . $item->description . '</a>';
                        $cnt++;
                    }
                    // 文字列を出力
                    echo $output;
                }
                ?>
            </marquee>
        </div>
    </footer>
    <div class="postsbody post-modal">
        <button type="button" class="post-modal-close">✖</button>
        <h2 class="posts_h2">投稿</h2>
        <form action="newPost" method="post" enctype="multipart/form-data">
            @csrf
            <div class="posts">
                <div>
                    <input type="file" name="image" class="imgbtn" value="画像を追加する">
                </div>
                <div class="postarea">
                    <textarea name="text" class="post" cols="40" rows="8" placeholder="投稿内容を入力してください。"></textarea>
                </div>
                <div class="post-buttons">
                    <input type="submit" class="postpush" 　name="#" value="投稿する">
                </div>
            </div>
        </form>
    </div>
    <div class="commentbody comment-modal">
        <button type="button" class="comment-modal-close">✖</button>
        <h2 class="comment_h2">コメント</h2>
        <form action="/newComment" method="post">
            @csrf
            <div class="comments">
                @if (isset($message['message']))
                <span class="errors">{{ $message['message'] }}</span>
                @endif
                <div class="commentarea">
                    <textarea name="text" class="comment" cols="40" rows="8" placeholder="コメントを入力してください。"></textarea>
                </div>
                <div class="comment-buttons">
                    <input type="submit" class="commentpush" 　name="btn" value="コメント">
                    <input type="hidden" id="userid" name="id" value="">
                </div>
            </div>
        </form>
    </div>
    <div class="AccountRoom Account-modal">
        <button type="button" name="mypost" class="Account-modal-close">✖</button>
        <h2 class="accountTitle">設定</h2>
        <div class="AccountButtons">
            <div>
                <button type="button" class="custom" onclick="location.href='/accountView'">アカウント情報</button>
            </div>
            <div>
                <button type="button" class="postmemory" onclick="location.href='/myPosts'">投稿履歴</button>
            </div>
            <div>
                <button type="submit" class="accountdelete" onclick="location.href='/accountDelete'">退会</button>
            </div>
        </div>
    </div>
</body>

</html>