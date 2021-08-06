
//投稿モーダルの表示
$(function () {
    $('.post-modal-open').on('click', function () {
        $('.post-modal').fadeIn();
        return false;
    });
    $('.post-modal-close').on('click', function () {
        $('.post-modal').fadeOut();
        return false;
    });
});

//コメントモーダルの表示
$(function () {
    $('.comment-modal-open').on('click', function () {
        $('.comment-modal').fadeIn();

        var btn = $(this).val();
        console.log(btn);

        $('#userid').val(btn);

        return false;
    });
    $('.comment-modal-close').on('click', function () {
        $('.comment-modal').fadeOut();
        return false;
    });
});

//設定モーダルの表示
$(function () {
    $('.Account-modal-open').on('click', function () {
        $('.Account-modal').fadeIn();

        return false;
    });
    $('.Account-modal-close').on('click', function () {
        $('.Account-modal').fadeOut();
        return false;
    });
});

//キーワード検索モーダルの表示
$(function () {
    $('.keyword-modal-open').on('click', function () {
        $('.keyword-modal').fadeIn();

        return false;
    });
    $('.keyword-modal-close').on('click', function () {
        $('.keyword-modal').fadeOut();
        return false;
    });
});

//アップデートモーダルの表示
$(function () {
    $('.Update-modal-open').on('click', function () {
        $('.Update-modal').fadeIn();

        return false;
    });
    $('.Update-modal-close').on('click', function () {
        $('.Update-modal').fadeOut();
        return false;
    });
});


//投稿編集モーダルの表示
$(function () {
    $('.postUpdate-modal-open').on('click', function () {
        $('.postUpdate-modal').fadeIn();

        var btn = $(this).val();
        console.log(btn);

        $('#userid').val(btn);

        return false;
    });
    $('.postUpdate-modal-close').on('click', function () {
        $('.postUpdate-modal').fadeOut();
        return false;
    });
});


//アカウント削除モーダルの表示
$(function () {
    $('.account-deletemodal-open').on('click', function () {
        $('.account-delete-modal').fadeIn();

        return false;
    });
    $('.accountdelete-modal-close').on('click', function () {
        $('.account-delete-modal').fadeOut();
        return false;
    });
});

//退出のアラートの表示
// function disp() {

//     if (window.confirm('ログイン画面にもどります。よろしいですか？')) {

//         location.href = "/login";

//     }
//     else {


//     }

// }