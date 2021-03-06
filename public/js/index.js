$(function(){
    $("#gallery").unitegallery();
    /*=================================================
      スマホメニュー
    ===================================================*/
    // ハンバーガーメニューのクリックイベント
    // 解説は、「中級編：ストアサイト（インテリア）」参照
    $(".toggle_btn").on('click', function() {
        if (!$('#header').hasClass('open')) {
            $('#header').addClass('open');
        } else {
            $('#header').removeClass('open');
        }
    });

    // #maskのエリアをクリックした時にメニューを閉じる
    $('#mask').on('click', function() {
        $('#header').removeClass('open');
    });

    // リンクをクリックした時にメニューを閉じる
    $('#navi a').on('click', function() {
        $('#header').removeClass('open');
    });

    // DOMの生成
    var $ele = $("<div class='fav_wrapper'><img class='heart' src='http://localhost:8888/Gallery/public/storage/images/icon/heart.png'></img><span class='fav_num'>0</span></div>");
    $('.ug-gallery-wrapper').append($ele);

    // タイトル保持用
    var $tmp_title;
    // 写真をクリックされた時にタイトル名保持
    $('.ug-thumb-wrapper').on('click', function() {
        $tmp_title = $(this).children('img').attr('alt');
        $.ajax({
            url: 'http://160.16.148.142/favorite/get_favorite',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'title': $tmp_title
            }
        }).done(function(data) {
            if (data != 'error') {
                $('.fav_wrapper').remove();
                $('.ug-gallery-wrapper').append("<div class='fav_wrapper'><img class='heart' src='http://localhost:8888/Gallery/public/storage/images/icon/heart.png'></img><span class='fav_num'>" + data + "</span></div>");
            } else {
                console.log('error');
            }
        }).fail(function(xhr, ajaxOptions, thrownError) {
            console.log('fail');
        });
    });

    // ハートをクリックされた場合
    $(document).on('click', '.heart', function() {
        // 通信が終わるまではクリック無効
        $(this).css('pointer-events', 'none');
        $.ajax({
            url: 'http://160.16.148.142/favorite/add_favorite',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'title': $tmp_title
            }
        }).done(function(data) {
            if (data != 'error') {
                $('.fav_wrapper').remove();
                $('.ug-gallery-wrapper').append("<div class='fav_wrapper'><img class='heart' src='http://localhost:8888/Gallery/public/storage/images/icon/heart.png'></img><span class='fav_num'>" + data + "</span></div>");
            } else {
                console.log('error');
            }
        }).fail(function(xhr, ajaxOptions, thrownError) {
            console.log('fail');
        }).always(function() {
            // クリック有効化
            $('.heart').css('pointer-events', 'auto');
        });
    });
});