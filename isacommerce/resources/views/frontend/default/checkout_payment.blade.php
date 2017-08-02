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
            <div class="heading-counter warning">Shipping Address : {{session('address')}}, {{session('city')}} {{session('postcode')}}
                
            </div>
            <div class="order-detail-content">
                <table class="table table-bordered table-responsive cart_summary">
                    <thead>
                        <tr>
                            <th class="cart_product">Product</th>
                            <th>Description</th>
                            <th>Unit price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <form class="form-horizontal ale-form" method="post" name="paymentForm" action="{{ url('payment') }}">
                        {{ csrf_field() }}
                       
                    <tbody>
                        <?php 
                        $total   = 0;
                        $tax     = 0;
                        ?>
                        @foreach($data['cart'] as $c)
                            <?php 
                                $date = date('Y-m-d H:i:s');
                                if(!empty($c->discount_amount ) && ($c->discount_amount !=0 ) &&  ($c->is_active == 'Y') && ($c->expiry > $date )){
                                    if($c->discount_operation == '-'){
                                        $price = $c->price - $c->discount_amount;
                                    }elseif($c->discount_operation == '%'){
                                        $price = $c->price - ($c->price*$c->discount_amount/100);
                                    }elseif($c->discount_operation == 's'){
                                        $price = $c->discount_amount;
                                    }
                                }else{
                                    $price = $c->price;
                                }
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <a href="#"><img src="{{ url('theme/backend/images/product/', [$c->image])}}" alt="Product"></a>
                                </td>
                                <td class="cart_description">
                                    <p class="product-name"><a href="#">{{$c->product_name}}</a></p>
                                    <small class="cart_ref">SKU : {{$c->sku}}</small><br>
                                    <small><a href="#">Color : Beige</a></small><br>   
                                    <small><a href="#">Size : S</a></small>
                                </td>
                                <td class="price"><span>{{number_format($price, 2)}}</span></td>
                                <td class="qty">
                                    {{$c->quantity}}
                                </td>
                                <td class="price">
                                    <span>{{number_format($price*$c->quantity, 2)}}</span>
                                </td>
                            </tr>
                            <?php 
                            $total       += $price*$c->quantity; 
                            $tax         = $total*0.1;
                            $grand_total = $total + $tax;
                            ?>
                            <input type="hidden" class="form-control" name="session_id" required value="{{$c->session_id}}">
                        @endforeach
                    </tbody>
                    </form>
                    <tfoot>
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <td colspan="2">Total</td>
                            <td>{{number_format($total, 2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Total products (tax incl.)</strong></td>
                            <td>{{number_format($tax, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Grand Total (IDR)</strong></td>
                            <td><strong>{{number_format($grand_total, 2)}}</strong></td>
                        </tr>
                    </tfoot>    
                </table>
                <div class="cart_navigation">
                    <a class="prev-btn" href="{{ url('checkout/address') }}">Back</a>
                    <a class="next-btn" href="#" onclick="document.forms['paymentForm'].submit();return false;">Proceed to checkout</a> 
                </div>
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