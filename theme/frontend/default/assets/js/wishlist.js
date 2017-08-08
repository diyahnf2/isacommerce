$(document).ready(function() {
    var baseUrl = $("#baseurl").val();
    $(".heart").each(function() {
        var id = this.id;
        $.ajax({
            url: baseUrl+'/check-wishlist/'+id,
            type: "GET",
            dataType: "json",
            success:function(data){
                if(data == 1){
                     //alert("ada" + id);
                    $('a.wishlist_' + id).css({"background-color": "#ff3366", "border-radius":"90%", "width":"30px", "height":"30px"});
                    $('a.wishlist_' + id).addClass( "listed" );
                }else{
                     //alert("tidak ada" + id);
                    $('a.wishlist_' + id).css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%", "border-radius":"90%", "width":"30px", "height":"30px"});
                    $('a.wishlist_' + id).removeClass( "listed" );
                }
            }
        });
    });
});

function wishlist(product_id)
{
    var baseUrl = $("#baseurl").val();
    if(product_id == 0){
        alert('Please select option(s) first');
    }else{
        if($("a").hasClass("listed") == true){
            $.ajax({
                url: baseUrl+'/remove-wishlist/'+product_id,
                type: "GET",
                dataType: "json",
                success:function(data){
                    if(data == 500){
                        alert('There was a problem remove the wishlist');
                    }
                    else{
                        $('a.wishlist_' + product_id).css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%"});
                        $('a.wishlist_' + product_id).removeClass( "listed" );
                    }
                }
            });
        }else{
            $.ajax({
                url: baseUrl+'/create-wishlist/'+product_id,
                type: "GET",
                dataType: "json",
                success:function(data){
                    if(data == 0){
                        alert('You must login to add items to your wishlist');
                    }else if(data == 500){
                        alert('There was a problem adding the wishlist');
                    }
                    else{
                        $('a.wishlist_' + product_id).css({"background-color": "#ff3366"});
                        $('a.wishlist_' + product_id).addClass("listed");
                    }
                }
            });
        }
    }
}

