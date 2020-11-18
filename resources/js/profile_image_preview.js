$(function(){
  let image_field = $("#Profile-image");
  image_field.on('change', function(e){
    var html = `
                  <img id="Profile-preview-area__image"></img>
                `;


    var image = $("#Profile-preview-area__image").length;
    var file = e.target.files[0];
    var reader = new FileReader();

    //アップロードした画像を設定する
    reader.onload = (function(file){
      return function(e){
        // var image = $("#image").length;
        console.log(image);
        $("#Profile-preview-area__image").attr("src", e.target.result);
      };
    })(file);
    reader.readAsDataURL(file);
    if(image == 0){
      $("#Profile-preview-area").show();
      $("#Profile-preview-area").append(html);
      $(".Profile-area__left").hide();
    }
  });

});