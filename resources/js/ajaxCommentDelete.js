$(function() {
    var commentId;

    $(document).on("click", "#commentDeleteBtn", function() {
        var $this = $(this);
        commentId = $this.attr("data-comment_id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/ajaxCommentDelete",
            dataType: "json",
            type: "POST",
            data: {
                comment_id: commentId, //削除したいコメントのID
                _method: "DELETE"
            }
        })
            // 成功
            .done(function(data) {
                // コメントがありませんを作成
                var html = `
                <div class="Empty-message">
                  <p>コメントはまだありません</p>
                </div>
              `;
                // コメントがありませんのメッセージがあるかどうか判定
                // あらかじめコメントが入っている場合
                if ($(".Empty-message").length == 0) {
                    // さらにあらかじめコメントが一つの場合と複数の場合で判定
                    if ($(".Comment").length == 1) {
                        $this.parents(".Comment").remove();
                        $("#Add-empty").append(html);
                    } else {
                        $this.parents(".Comment").remove();
                    }
                } else {
                    // あらかじめコメントが入ってない場合
                    // さらにコメントが追加された後の判定
                    if ($(".Comment").length == 1) {
                        $(".Empty-message").show();
                        $this.parents(".Comment").remove();
                    } else {
                        $this.parents(".Comment").remove();
                    }
                }
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
