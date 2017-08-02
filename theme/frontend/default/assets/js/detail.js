
    $("a#wishlist").click(function(){
        var product_id = $("#product_id").val();
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
                            $('.wishlist .fa').css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%"});
                            $('a#wishlist').removeClass( "listed" );
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
                            $('.wishlist .fa').css({"background-color": "#ff3366"});
                            $('a#wishlist').addClass( "listed" );
                        }
                    }
                });
            }
        }
    }); 

    $(document).ready(function() {
        var product_id = $("#product_id").val();
        var baseUrl = $("#baseurl").val();
        $.ajax({
            url: baseUrl+'/check-wishlist/'+product_id,
            type: "GET",
            dataType: "json",
            success:function(data){
                if(data == 1){
                    $('.wishlist .fa').css({"background-color": "#ff3366", "border-radius":"90%", "width":"30px", "height":"30px"});
                    $('a#wishlist').addClass( "listed" );
                }else{
                    $('.wishlist .fa').css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%", "border-radius":"90%", "width":"30px", "height":"30px"});
                    $('a#wishlist').removeClass( "listed" );
                }
            }
        });
    });

    $(document).ready(function() {
        $('#submitForm').click(function() {
            var stock      = $("span#in-stock").text();
            var product_id = $("#product_id").val();
            var baseUrl = $("#baseurl").val();
            if(stock == 0){
                alert('Sorry, this product has been out of stock');
            }else{
                //$("#detailForm" ).submit();
                $.ajax({
                    url: baseUrl+'/buy-detail/'+product_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                        if(data == 500){
                            alert('There was a problem to submit the data');
                        }
                        else{
                            $.ajax({
                                url: baseUrl+'/get-cart',
                                type: "GET",
                                dataType: "json",
                                success:function(cart){
                                    var total = 0;
                                    $("span#cart-elemen").empty();
                                    $("span#cart-elemen").append(cart.length);
                                    $("span#total").empty();
                                    $("span#total").append(cart.length+' Items');
                                    $("h5#cart-title").empty();
                                    $("h5#cart-title").append(cart.length+' Items in my cart');
                                    $("ul#cart-list").empty();
                                    $.each(cart, function(i, key){
                                        $('ul#cart-list').append('<li class="product-info"><div class="p-left"><a class="remove_link" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'+baseUrl+'/cart/delete/'+key.cart_id+'"></a><a href="#"><img class="img-responsive" src="'+baseUrl+'/theme/backend/images/product/'+key.image+'" alt="p10"></a></div><div class="p-right"><p class="p-name">'+key.product_name+'</p><p class="p-rice">'+accounting.formatMoney(key.price, "", 2, ",", ",")+'</p><p>Qty: '+key.quantity+'</p></div></li>');
                                        total = total + (key.price*key.quantity);
                                    });
                                    $("span#total-price").empty();
                                    $("span#total-price").append(accounting.formatMoney(total, "", 2, ",", ","));
                                }
                            });
                        }
                    }
                });
            }
        });
    });
