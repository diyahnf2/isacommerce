<!DOCTYPE html>
<html>
<head>
    @include('frontend.default.partials.meta')
    <title>ISA Commerce - Best Ecommerce Platform</title>
</head>
<body class="option6 category-page">
@include('frontend.default.partials.header')

<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="{{url('/')}}" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Your shopping cart</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading no-line">
            <span class="page-heading-title2">Shopping Cart Summary</span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content page-order">
            <ul class="step">
                <li><span>01. Summary</span></li>
                <li><span>02. Sign in</span></li>
                <li><span>03. Address</span></li>
                <li><span>04. Shipping</span></li>
                <li class="current-step"><span>05. Payment</span></li>
            </ul>
            <div class="heading-counter warning">{{ $data['message'] }}          
            </div> 
        </div>
    </div>
</div>
<!-- ./page wapper-->

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: 'http://localhost/isacommerce.com/province/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="province"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="province"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="province"]').empty();
            }
        });
    });
</script>

</body>
</html>