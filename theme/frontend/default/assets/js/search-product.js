$(document).ready(function() {
     $('#js-search').click(function() {
        var keyword  = $("#keyword").val();
        var category = $("#select-category option:selected" ).val();
        var url_value = category + '&' + keyword;
        var baseUrl = $("#baseurl").val();
        
        window.location.replace(baseUrl+"/search-product/" + url_value);
    });
});

    