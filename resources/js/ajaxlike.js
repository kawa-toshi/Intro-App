$(function() {
    var like = $(".js-like-toggle");
    var likePostId;
    var canAjax = true; // 連打防止

    like.on("click", function() {

      if(!canAjax){
        console.log('通信中');
        return
      }

      canAjax = false;


        var $this = $(this);
        likePostId = $this.data("post_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/ajaxlike", //routeの記述
            type: "POST", //受け取り方法の記述
            data: {
                post_id: likePostId //コントローラーに渡すパラメーター
            }
        })

            // 成功
            .done(function(data) {
                //lovedクラスを追加
                $this.toggleClass("loved");
                //.likesCountの次の要素のhtmlを「data.postLikesCount」の値に書き換える
                $this.next(".likesCount").html(data.postLikesCount);

                if($this.hasClass("loved")){
                  $this.addClass("Big");
                }else{
                  $this.removeClass("Big");
                }
            })
            // 失敗
            .fail(function(data, xhr, err) {
                // エラー内容を記述。
                console.log("エラー");
                console.log(err);
                console.log(xhr);
            }).always(function(){
              canAjax = true;
            });

        return false;
    });
});
