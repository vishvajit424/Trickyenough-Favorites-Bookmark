/*------------------------ 
Backend related javascript
------------------------*/
jQuery(document).ready(function(){
    $('form#save_bookmark').unbind("submit").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: favorites_ajax_object.ajax_url,
            type: "POST",
            data: $(this).serialize(),
            success: function(data){
                $("#bookmark_icon").attr('class', 'fa fa-bookmark');
                $("#favorite_popup_msg").text("Bookmark Added");
                $(".favorites-popup").fadeIn(500);
                //$("form").attr("id","remove_bookmark");
                //$("#form-action").val("removBookmark");
            },
            error: function(){
                console.log(data);
            }
        });
    });
    $('form#remove_bookmark').unbind("submit").submit(function(e){
        e.preventDefault();
       // var data =  $(this).serialize();
        $.ajax({
            url: favorites_ajax_object.ajax_url,
            type: "POST",
            data: $(this).serialize(),
            success: function(data){
                 $("#bookmark_icon").attr('class', 'fa fa-bookmark-o');
                  $("#favorite_popup_msg").text("Bookmark Removed");
                  $(".favorites-popup").fadeIn(500);
                  //$("form").attr("id","save_bookmark");
                 //$("#form-action").val("savePost");
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".close").click(function() {
     $(".favorites-popup").fadeOut(500);
    });
});