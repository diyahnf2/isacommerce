    $(document).ready(function() {
        $('ul#product-list-index').on('click', '.cart-to-add', function() {
            var id = $(this).closest('li').index();
            var stock      = $("#quantity_"+id).val();  
            var product_id = $("#product_id_"+id).val();
            var seo       = $("#seo_"+id).val();
            if(stock == 0){
                alert('Sorry, this product has been out of stock');
            }else{
                var baseUrl = $("#baseurl").val();
                $.ajax({
                    url: baseUrl+'/buy-direct/'+product_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                        if(data == 500){
                            alert('There was a problem adding to cart');
                        }else if(data == 200){
                            window.location.href = baseUrl+"/product/"+seo;
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
