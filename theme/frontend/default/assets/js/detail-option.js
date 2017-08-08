
    $(document).ready(function() {
        var count_combination = $("#count_combination").val();
        var parent_id = $("#parent_id").val();
        var baseUrl = $("#baseurl").val();
        var c;
        var q;
        $(".selectId").on('change', function() {
            var selectVal = new Array();
            var val = new Array();
            var j = 0;
            var selecttedOptArr = new Array();
            var selectedOpt = $(this).val();
            selecttedOptArr = selectedOpt.split("|");
            //alert(selecttedOptArr[0]);
            for(c=1; c<=selecttedOptArr[0]; c++){ // change with n
                selectVal[c] = $('#selectId_'+c+' option:selected').val();
                if(selectVal[c] != ''){
                    val[j] = selectVal[c]
                    j++;
                }
            }
            if(selecttedOptArr[0] < count_combination){
                $('.wishlist .fa').css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%"});
                $('a#wishlist').removeClass( "listed" );
                $.ajax({ 
                    url: baseUrl+'/detail-filter',
                    type: "POST",
                    dataType: "json",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'attribute_value': val,
                        'parent_id': parent_id
                    },
                    success:function(data){
                        var valName = new Array();
                        var valID   = new Array();
                        var n;
                        var m = 0;
                        var countData = +selecttedOptArr[0] + 1;
                        $.each(data, function(i, key) {
                            var valueName = key.value_name;
                            var valID     = key.value_id;
                            valName = valueName.split(",");
                            valID   = valID.split(",");
                            $('select#selectId_'+countData).empty(); 
                            $('select#selectId_'+countData).append('<option value="">- Pilih -</option>');
                            if(m == 0){
                                for(n=0; n<valName.length; n++){
                                    $('select#selectId_'+countData).append('<option value="'+ countData +'|'+ key.attribute_id +'|'+ valID[n] +'">'+ valName[n] +'</option>');
                                }
                            }
                            m++;
                            countData++;
                        });
                    }
                });
            }else{
                $.ajax({ // buat cek harga, ambil semua data di option lalu dapetin id-product + harga + availability
                    url: baseUrl+'/detail-price',
                    type: "POST",
                    dataType: "json",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'attribute_value': val,
                        'parent_id': parent_id
                    },
                    success:function(data){
                        var valName = new Array();
                        var valID   = new Array();
                        var n;
                        var m = 0;
                        var countData = +selecttedOptArr[0] + 1;  
                        var product_id = data.product_id;
                        $("input#product_id").val(data.product_id);
                        $(".product-price-group span#product-discount").empty();
                        $(".product-price-group span#price").empty();
                        $(".product-price-group span#price").append(accounting.formatMoney(data.price, "", 2, ",", ","));
                        $(".info-orther p span#in-stock").empty();
                        $(".info-orther p span#in-stock").append(data.quantity);
                        $(".product-price-group span#discount").remove();
                        $(".product-price-group span#old-price").remove();
                        if(data.discount != 0){
                            $(".product-price-group span#product-discount").empty();
                            $(".product-price-group span#product-discount").append('<span class="old-price" id="old-price">'+accounting.formatMoney(data.old_price, "", 2, ",", ",")+'</span>');
                            $(".product-price-group span#product-discount").append('<span class="discount" id="discount">'+data.discount+'</span>');
                        }
                        $.ajax({
                            url: baseUrl+'/check-wishlist/'+product_id,
                            type: "GET",
                            dataType: "json",
                            success:function(data){
                                if(data == 1){
                                    $('.wishlist .fa').css({"background-color": "#ff3366"});
                                    $('a#wishlist').addClass( "listed" );
                                }else{
                                    $('.wishlist .fa').css({"background-color": "rgba(0, 0, 0, 0.4) none repeat scroll 0% 0%"});
                                    $('a#wishlist').removeClass( "listed" );
                                }
                            }
                        });
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('#submitForm').click(function() {
            var stock      = $(".info-orther p span#in-stock").text();
            var product_id = $("#product_id").val();
            var baseUrl = $("#baseurl").val();
            if(stock == '-' || product_id == 0){
                alert('Please select option(s) first');
            }else if(stock == 0){
                alert('Sorry, this product has been out of stock');
            }else{
                //$("#detailForm" ).submit();
                $.ajax({
                    url: baseUrl+'/buy-detail/'+product_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                        if(data == 500){
                            alert('There was a problem remove the wishlist');
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
                                    $.each(cart, function(i, key) {
                                        //$('ul#cart-list').append('<option value="'+ countData +'|'+ key.attribute_id +'|'+ valID[n] +'">'+ valName[n] +'</option>');
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

  