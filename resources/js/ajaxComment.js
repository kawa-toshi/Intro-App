$(function() {
    var comment = $(".Comment-submit__btn");
    var likePostId;

    comment.on("click", function() {
        var $this = $(this);
        var text = $("#Comment-post__textarea").val();
        likePostId = $this.data("post_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/ajaxComment",
            dataType: "json",
            type: "POST",
            data: {
                post_id: likePostId, //ユーザーid.ポストid.テキストがあればいい
                text: text //コントローラーに渡すパラメーター コントローラーの$requestのなかに入る 現在のコメントのデータ
            }
        })
            // 成功
            .done(function(data) {
                console.log(data.post_id);
                console.log(data.text);
                console.log(data.user_id);
                $(".Empty-message").hide();

                var html = `
                <div class="Comment">
                    <div class="Profile-box">
                      <div class="Profile-box__content">
                        <img class="Profile-img" src="http://localhost:8888/storage/${data.profile_image}" alt="" />
                        <div>
                          <p>${data.user_name}</p>
                          <p>${data.created_at}</p>
                        </div>
                      </div>
                    </div>
                    <div class="Comment__text">
                      <p>${data.text} </p>
                    </div>
                    
                    <div class="Btn-wrraper">
                      <form method="DELETE" action="http://localhost:8888/ajaxCommentDelete">
                          <button type="submit" id="commentDeleteBtn" data-comment_id=${data.comment_id}>
                            削除
                          </button>
                      </form>
                    </div>
                  </div>
                `;

                $("#Add-comment").append(html);
            })
            // 失敗
            .fail(function(data, xhr, err) {
                // エラー内容を記述。
                console.log("エラー");
                console.log(err);
                console.log(xhr);
            });

        return false;
    });
});
