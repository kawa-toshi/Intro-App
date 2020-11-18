$(function(){
  let image_field = $("#Cover-image");
  image_field.on('change', function(e){
    var html = `
                  <img id="Cover-preview-area__image"></img>
                `;


    var image = $("#Cover-preview-area__image").length;
    var file = e.target.files[0];
    var reader = new FileReader();

    //アップロードした画像を設定する
    reader.onload = (function(file){
      return function(e){
        // var image = $("#image").length;
        console.log(image);
        $("#Cover-preview-area__image").attr("src", e.target.result);
      };
    })(file);
    reader.readAsDataURL(file);
    if(image == 0){
    $("#Cover-preview-area").show();
    $("#Cover-preview-area").append(html);
    $(".Cover-image-area").hide();
    }
  });

});