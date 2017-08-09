$(document).ready(function() {
     $('#js-filter').click(function() {
        var pathArray = window.location.pathname.split( '/' );
        var last_path  = pathArray[4].split('=');
        var pathname  = pathArray[0] + '/' + pathArray[1] + '/' + pathArray[2] + '/' + pathArray[3] + '/'+ last_path[0];
        var backurl   = window.location.pathname;
        var price = [];
        var i = 0;
        var max = false;

        $("input.price-range[type=checkbox]:checked").each(function() {
            var price_range = $(this).val()
            split_price_range = price_range.split('-');
            for(var j=0; j<2; j++){
                if(split_price_range[j] == 'lebih'){
                    max = true;
                }else{
                    price[i] = split_price_range[j];
                    i++;
                }
            }
        });

        if(i > 0){
            var min_price = Math.min.apply(null, price);
            var max_price = Math.max.apply(null, price);
            if(max == false){
                var urls = pathname + '=' + min_price + '&' + max_price;
            }else{
                var urls = pathname + '=' + min_price + '&' + 'more';
            }
            window.location.replace(urls);
        }else{
            window.location.replace(backurl);
        }
    });
});

    