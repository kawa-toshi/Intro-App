$(function(){
  let image_field = $('#Post-image');
  image_field.on('change', function(e){
    var html = `
                  <img id="PreviewArea__image" style="width:300px;height:200px;"></img>
                `;


    var image = $("#PreviewArea__image").length;
    var file = e.target.files[0];
    var reader = new FileReader();

    //アップロードした画像を設定する
    reader.onload = (function(file){
      return function(e){
        // var image = $("#image").length;
        console.log(image);
        $("#PreviewArea__image").attr("src", e.target.result);
      };
    })(file);
    reader.readAsDataURL(file);
    if(image == 0){
    $("#PreviewArea__previous").hide();
    $("#PreviewArea").append(html);
    }
  });

});