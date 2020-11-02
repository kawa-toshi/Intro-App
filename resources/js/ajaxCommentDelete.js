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
                // メッセージ無しのメッセージがあるかどうか判定
                if ($(".Empty-message").length == 0) {
                    console.log(data.comment_id);
                    $this.parents(".Comment").remove();
                } else {
                    if ($(".Comment").length == 1) {
                        $(".Empty-message").show(); // 最後のコメントが消された時だけメッセージ無しを表示する
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
